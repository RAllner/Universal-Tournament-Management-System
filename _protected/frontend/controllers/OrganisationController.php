<?php

namespace frontend\controllers;

use frontend\models\OrganisationHasUser;
use Yii;
use frontend\models\Organisation;
use frontend\models\OrganisationSearch;
use yii\db\IntegrityException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UploadedFile;

/**
 * OrganisationController implements the CRUD actions for Organisation model.
 */
class OrganisationController extends FrontendController
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
     * Lists all Organisation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganisationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organisation model.
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
     * Creates a new Organisation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->can('createOrganisation')){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['index']);
        }
        $model = new Organisation();
        $model->user_id = Yii::$app->user->id;

        $memberModel = new OrganisationHasUser();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->save())
            {
                $memberModel->user_id = Yii::$app->user->id;
                $memberModel->organisation_id = $model->id;
                $memberModel->admin = 1;
                $memberModel->created_at = $model->created_at;
                $memberModel->updated_at = $model->updated_at;
                if($memberModel->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
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
     * Updates an existing Organisation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can('updateOrganisation', ['model' => $this->findModel($id)])){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['view', 'id' => $this->findModel($id)->id]);
        }
        $currentModel = $this->findModel($id);
        $model = $this->findModel($id);

        if (Yii::$app->user->can('updateArticle', ['model' => $model]))
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
     * @param $id
     * @return string|\yii\web\Response
     * @throws IntegrityException
     * @throws NotFoundHttpException
     */
    public function actionAdd($id){
        if(!Yii::$app->user->can('updateOrganisation', ['model' => $this->findModel($id)])){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['view', 'id' => $this->findModel($id)->id]);
        }
        $model = new OrganisationHasUser();
        $organisationModel = $this->findModel($id);
        $model->organisation_id = $id;
        if ($model->load(Yii::$app->request->post()))
        {
            if (!OrganisationHasUser::find()->where(['organisation_id' => $model->organisation_id, 'user_id'=> $model->user_id])->exists()){
                if($model->save())
                {
                    return $this->redirect(['view', 'id' => $organisationModel->id]);
                }
            }else {
                Yii::$app->session->setFlash('error', 'User is already part of the organisation');
                return $this->redirect(['add', 'id' => $organisationModel->id]);

            }

        }
        else
        {
            return $this->render('add', [
                'model' => $model,
            ]);
        }
    }

    public function actionRemoveMember($id, $memberID){
        if(!Yii::$app->user->can('updateOrganisation', ['model' => $this->findModel($id)])){
            Yii::$app->session->setFlash('error', Yii::t('app', 'You are not allowed to access this page.'));
            return $this->redirect(['view', 'id' => $this->findModel($id)->id]);
        }
        $member = OrganisationHasUser::findOne(['organisation_id' => $id, 'user_id'=> $memberID]);
        $member->delete();
        return $this->redirect(['view', 'id' => $this->findModel($id)->id]);
    }
    /**
     * Deletes an existing Organisation model.
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
     * Admin Organisations.
     * @return mixed
     * @throws MethodNotAllowedHttpException
     */
    public function actionAdmin()
    {
        /**
         * How many articles we want to display per page.
         * @var integer
         */

        $searchModel = new OrganisationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->user->can('adminOrganisation')){
            return $this->render('admin', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else throw new MethodNotAllowedHttpException(Yii::t('app', 'You are not allowed to access this page.'));
    }



    /**
     * Finds the Organisation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Organisation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organisation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
