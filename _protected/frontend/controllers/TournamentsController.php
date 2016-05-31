<?php

namespace frontend\controllers;

use Yii;
use app\models\Tournaments;
use app\models\TournamentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TournamentsController implements the CRUD actions for Tournaments model.
 */
class TournamentsController extends Controller
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
     * Lists all Tournaments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TournamentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tournaments model.
     * @param integer $idtournaments
     * @param integer $user_id
     * @return mixed
     */
    public function actionView($idtournaments, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($idtournaments, $user_id),
        ]);
    }

    /**
     * Creates a new Tournaments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tournaments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idtournaments' => $model->idtournaments, 'user_id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tournaments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idtournaments
     * @param integer $user_id
     * @return mixed
     */
    public function actionUpdate($idtournaments, $user_id)
    {
        $model = $this->findModel($idtournaments, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idtournaments' => $model->idtournaments, 'user_id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tournaments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idtournaments
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($idtournaments, $user_id)
    {
        $this->findModel($idtournaments, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tournaments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idtournaments
     * @param integer $user_id
     * @return Tournaments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idtournaments, $user_id)
    {
        if (($model = Tournaments::findOne(['idtournaments' => $idtournaments, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




}
