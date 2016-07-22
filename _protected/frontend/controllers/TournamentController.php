<?php

namespace frontend\controllers;

use frontend\models\Participant;
use Yii;
use frontend\models\Tournament;
use frontend\models\TournamentSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TournamentController implements the CRUD actions for Tournament model.
 */
class TournamentController extends FrontendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'abort' => ['POST'],
                    'reset' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Tournament models.
     * @return mixed
     */
    public function actionIndex($filter = 0)
    {
        $searchModel = new TournamentSearch();
        if(!isset($_GET['filter'])){
            $_GET['filter'] = 0;
        }
        $time = new \DateTime('now');
        $today = $time->format('Y-m-d H:i:s');
        $allCount = Tournament::find()->count();
        $commingCount = Tournament::find()->where(['>=', 'begin', $today])
            ->andWhere(['not', ['status' => 3]])
            ->count();
        $runningCount = Tournament::find()->where(['status' => 3])->count();
        $pastCount = Tournament::find()->where(['<=', 'begin', $today])
            ->andWhere(['not', ['status' => 3]])
            ->count();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $filter);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allCount' => $allCount,
            'commingCount' => $commingCount,
            'runningCount' => $runningCount,
            'pastCount' => $pastCount,
        ]);
    }

    /**
     * Displays a single Tournament model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a Tournament Tree of the only stage or the final stage.
     * @param integer $id
     * @return mixed
     */
    public function actionStage($id)
    {
        return $this->render('stage', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Displays a Tournament Tree of the only stage or the final stage.
     * @param integer $id
     * @return mixed
     */
    public function actionGroupStage($id)
    {
        return $this->render('groupStage', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Tournament model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tournament();
        $this->loadDefault($model);
        if ($model->load(Yii::$app->request->post())) {
            if($model->hosted_by == -1){
                $model->user_id = Yii::$app->user->id;
            } else {
                $model->organisation_id = $model->hosted_by;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function loadDefault($model){
        $model->participants_compete = 4;
        $model->participants_advance = 2;
        $model->stage_type = 0;
        $model->fs_de_grand_finals = 0;
    }

    /**
     * Updates an existing Tournament model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->hosted_by == -1){
                $model->user_id = Yii::$app->user->id;
            } else {
                $model->organisation_id = $model->hosted_by;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }else {

                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionPublish($id)
    {
        $model = $this->findModel($id);

        $model->status = Tournament::STATUS_PUBLISHED;
        if($model->save()){
            Yii::$app->session->setFlash('success', 'The tournament now published.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Something went wrong.');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionStart($id)
    {
        if($this->getParticipantCount($id)<=2){
            $model = $this->findModel($id);

            $model->status = ($model->stage_type === 0) ? Tournament::STATUS_FINAL_STAGE : Tournament::STATUS_RUNNING;
            if($model->save()){
                return $this->redirect($redirect = ($model->stage_type === 0) ? ['stage', 'id' => $id] : ['group-stage', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', 'Something went wrong.');
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Not enough participants to start the tournament');
            return $this->redirect(['view', 'id' => $id]);
        }
    }


    public function actionAbort($id)
    {
        $model = $this->findModel($id);

        $model->status = Tournament::STATUS_ABORT;
        if($model->save()){
            Yii::$app->session->setFlash('info', 'The tournament is now aborted.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Something went wrong.');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionReset($id)
    {
        $model = $this->findModel($id);

        $model->status = Tournament::STATUS_PUBLISHED;
        //TODO: RESET ALL MATCH DATA
        if($model->save()){
            Yii::$app->session->setFlash('info', 'The tournament reset is finished.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Something went wrong.');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function getParticipantCount($id)
    {
        return Participant::find()->where(['tournament_id' => $id])->count();
    }

    /**
     * Deletes an existing Tournament model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tournament model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tournament the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tournament::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
