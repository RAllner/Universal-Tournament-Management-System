<?php

namespace frontend\controllers;

use frontend\models\Player;
use frontend\models\Team;
use Yii;
use frontend\models\Participant;
use frontend\models\ParticipantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParticipantController implements the CRUD actions for Participant model.
 */
class ParticipantController extends FrontendController
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
                ],
            ],
        ];
    }

    /**
     * Lists all Participant models.
     * @return mixed
     */
    public function actionIndex($tournament_id)
    {
        $searchModel = new ParticipantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $tournament_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStandings($tournament_id)
    {
        $searchModel = new ParticipantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $tournament_id, 1);

        return $this->render('standings', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Participant model.
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
     * Creates a new Participant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSignup($tournament_id)
    {
        $model = new Participant();
        $model->tournament_id = $tournament_id;
        $model = $this->loadDefault($model);
        if ($model->load(Yii::$app->request->post())){
            if(is_null($model->team_id)){
                $player = Player::find()->where(['id' => $model->player_id])->one();
                $model->name = $player->name . $player->running_nr;
            } else {
                $team = Team::find()->where(['id' => $model->team_id])->one();
                $model->name = $team->name;
            }
            if($model->save()) {
                $model->tournament->setParticipantCount();
                return $this->redirect(['tournament/view', 'id' => $model->tournament_id]);
            }

        } else {
            return $this->render('signup', [
                'model' => $model,
            ]);
        }
    }

    public function loadDefault($model){
        $model->signup = 1;
        $model->checked_in = 0;
        $model->seed = Participant::find()->where(['tournament_id' => $model->tournament_id])->count();
        $model->rank = 0;
        $model->removed = 0;
        $model->on_waiting_list = 0;
        return $model;
    }

    
    
    /**
     * Updates an existing Participant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Participant model.
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
     * Finds the Participant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Participant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Participant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
