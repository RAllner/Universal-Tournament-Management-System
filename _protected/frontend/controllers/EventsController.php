<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Events;
use frontend\models\EventsSearch;
use yii\web\NotFoundHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * EventsController implements the CRUD actions for Events model.
 */
class EventsController extends FrontendController
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
     * Lists all Events models.
     * @return mixed
     */
    public function actionIndex()
    {
        /**
         * How many events we want to display per page.
         * @var integer
         */
        $pageSize = 5;

        /**
         * Events have to be published.
         * @var boolean
         */
        $published = true;

        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Events model.
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
     * Creates a new Events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('createEventsAndLocations')){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['index']);
        }
        $model = new Events();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()))
        {
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
     * Updates an existing Events model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can('createEventsAndLocations')){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['index']);
        }
        $currentModel = $this->findModel($id);
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateEventsAndLocations', ['model' => $model]))
        {
            if ($model->load(Yii::$app->request->post()))
            {
                if($currentModel->name != $model->name){
                    //TODO: Name des Bildes ändern.
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
     * Deletes an existing Events model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteImage();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Manage Events.
     *
     * @return mixed
     */
    public function actionAdmin()
    {
        if(!Yii::$app->user->can('adminEventsAndLocations')){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['index']);
        }
        /**
         * How many articles we want to display per page.
         * @var integer
         */
        $pageSize = 10;

        /**
         * Only admin+ roles can see everything.
         * Editors will be able to see only published articles and their own drafts @see: search().
         * @var boolean
         */
        $published = (Yii::$app->user->can('admin')) ? false : true ;

        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the Events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Events::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}