<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Galleries;
use frontend\models\GalleriesSearch;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\MethodNotAllowedHttpException;


/**
 * GalleriesController implements the CRUD actions for Galleries model.
 */
class GalleriesController extends FrontendController
{

    /**
     * Lists all Galleries models.
     * @return mixed
     */
    public function actionIndex()
    {
        /**
         * How many galleries we want to display per page.
         * @var integer
         */
        $pageSize = 3;

        /**
         * Galleries have to be published.
         * @var boolean
         */
        $published = true;

        $searchModel = new GalleriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Galleries model.
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
     * Creates a new Galleries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Galleries();

        $model->user_id = Yii::$app->user->id;

            if ($model->load(Yii::$app->request->post()))
            {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');


                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                if ($model->upload()) {
                    // file is uploaded successfully
                    return;
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

    }

    /**
     * Updates an existing Galleries model.
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

        if (Yii::$app->user->can('updateGallery', ['model' => $model])) {

            if ($model->load(Yii::$app->request->post()))
            {
                if($oldModel->title != $model->title) {
                    $model->rename($oldModel->title, $model->title);
                }
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                if ($model->upload()) {
                    // file is uploaded successfully
                    return;
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
     * Deletes an existing Galleries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionDeleteImage($id, $imageID){
        $this->findModel($id)->deleteImage($imageID);
        return $this->redirect(['update', 'id' => $id]);
    }


    /**
     * Manage Articles.
     *
     * @return mixed
     */
    public function actionAdmin()
    {
        /**
         * How many articles we want to display per page.
         * @var integer
         */
        $pageSize = 11;

        /**
         * Only admin+ roles can see everything.
         * Editors will be able to see only published articles and their own drafts @see: search().
         * @var boolean
         */
        $published = (Yii::$app->user->can('admin')) ? false : true ;

        $searchModel = new GalleriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $pageSize, $published);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Galleries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Galleries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Galleries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
