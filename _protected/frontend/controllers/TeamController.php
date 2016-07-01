<?php

namespace frontend\controllers;

use frontend\models\Player;
use Yii;
use frontend\models\Team;
use frontend\models\TeamSearch;
use frontend\models\TeamMember;
use yii\db\IntegrityException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends FrontendController
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
                    'removeMember' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Team models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Team model.
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
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createPlayer')) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['index']);
        }
        $model = new Team();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Team model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $oldModel = $this->findModel($id);
        $model = $this->findModel($id);
        if (!(Yii::$app->user->can('updatePlayer', ['model' => $model]) || $model->isUsersPlayerAdmin())) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if ($model->load(Yii::$app->request->post())) {
                if ($oldModel->name != $model->name) {
                    $model->rename($oldModel->name, $model->name);
                }
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws IntegrityException
     * @throws NotFoundHttpException
     */
    public function actionAdd($id)
    {
        $teamModel = $this->findModel($id);
        if (!(Yii::$app->user->can('updatePlayer', ['model' => $teamModel]) || $teamModel->isUsersPlayerAdmin())) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.' ));
            return $this->redirect(['view', 'id' => $teamModel->id]);
        }
        $model = new TeamMember();
        $model->team_id = $id;
        if ($model->load(Yii::$app->request->post())) {
            if (!TeamMember::find()->where(['team_id' => $model->team_id, 'player_id' => $model->player_id])->exists()) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $teamModel->id]);
                }
            } else {
                Yii::$app->session->setFlash('error', 'User is already part of the organisation');
                return $this->redirect(['add', 'id' => $teamModel->id]);

            }

        } else {
            return $this->render('add', [
                'model' => $model,
            ]);
        }
    }




    /**
     * @param $id
     * @param $memberID
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionRemoveMember($id, $memberID)
    {
        $model = $this->findModel($id);
        if (!(Yii::$app->user->can('updatePlayer', ['model' => $model]) || $model->isUsersPlayerAdmin())) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if (($member = TeamMember::findOne(['team_id' => $id, 'player_id' => $memberID])) !== null) {
                $member->delete();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }   
    
    /**
     * @param $id
     * @param $memberID
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionSetMemberAdmin($id, $memberID, $set)
    {
        $model = $this->findModel($id);
        if (!(Yii::$app->user->can('updatePlayer', ['model' => $model]) || $model->isUsersPlayerAdmin()) ) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            if (($member = TeamMember::findOne(['team_id' => $id, 'player_id' => $memberID])) !== null) {
                $member->admin = $set;
                $member->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }


    /**
     * Deletes an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->teamMembers as $member){
            $member->delete();
        }
        $model->deleteImage();
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Admin Teams.
     * @return mixed
     * @throws MethodNotAllowedHttpException
     */
    public function actionAdmin()
    {
        /**
         * How many articles we want to display per page.
         * @var integer
         */

        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->user->can('adminPlayer')) {
            return $this->render('admin', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
    }

    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function findMemberModels($id)
    {
        if (($model[] = TeamMember::findAll(['team_id' => $id])) !== null) {
            return $model;
        } else {
            Yii::$app->session->setFlash('info', 'No Team Member to delete.');
        }
    }


    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Team::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
