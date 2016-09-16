<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Player;
use frontend\models\PlayerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;

/**
 * PlayersController implements the CRUD actions for Players model.
 */
class PlayerController extends Controller
{

    /**
     * Lists all Players models.
     * @return mixed
     */
    public function actionIndex()
    {
        /**
         * How many articles we want to display per page.
         * @var integer
         */
        $pageSize = 20;

        $searchModel = new PlayerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, false);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'showAll' => true
        ]);
    }

    public function actionOwnIndex(){

        $pageSize = 20;

        $searchModel = new PlayerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, true);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'showAll' => false
        ]);
    }

    /**
     * Displays a single Players model.
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
     * Creates a new Players model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('createPlayer')){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['own-index']);
        }

        $model = new Player();
        $model->gender = Player::GENDER_OTHER;
        $model->user_id = Yii::$app->user->id;
        $model->running_nr = 1;

        if ($model->load(Yii::$app->request->post()))
        {
            if(Player::find()->where(['name' => $model->name])->exists()){
                $highest_rn = Player::find()->where(['name' => $model->name])->orderBy(['running_nr' => SORT_DESC])->asArray()->one();
                $model->running_nr = $highest_rn['running_nr'] + 1;
            }
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Players model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $this->findModel($id);
        if(!Yii::$app->user->can('updatePlayer', ['model' => $model])){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['own-index']);
        }
        
        if (Yii::$app->user->can('updatePlayer', ['model' => $model]))
        {
            if ($model->load(Yii::$app->request->post()))
            {
                if($oldModel->name != $model->name){
                    $model->rename($oldModel->name, $model->name);
                }
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if($model->save())
                {
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
            else
            {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
        else
        {
            throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
        }
    }


    
    /**
     * Deletes an existing Players model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        if(!Yii::$app->user->can('deletePlayer', ['model' => $model])){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['index']);
        }

        $model->deleted_flag = 1;
        $model->save();
        return $this->redirect(['admin']);
    }


    /**
     * Manage Players.
     * @return mixed
     * @throws MethodNotAllowedHttpException
     */
    public function actionAdmin()
    {
        if(!Yii::$app->user->can('adminPlayer')){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['index']);
        }


        /**
         * How many players we want to display per page.
         * @var integer
         */
        $pageSize = 11;


        $searchModel = new PlayerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, false, true);
        if(Yii::$app->user->can('adminPlayer')){
        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        } else throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
    }

    /**
     * Finds the Players model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Players the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Player::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
