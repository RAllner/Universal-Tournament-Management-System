<?php

namespace frontend\controllers;

use frontend\models\Bulk;
use frontend\models\Player;
use frontend\models\Team;
use frontend\models\Tournament;
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
        $tournament = Tournament::find()->where(['id' => $tournament_id])->one();

        $source[] = null;
        foreach (Player::find()->all() as $player){
            $object  = (object)[ 'label' => $player['nameWithRunningNr'], 'value' => $player['id']];
            $source[] = $object;
        }

        $bulk = new Bulk();
        $bulk->tournament_id = $tournament_id;
        $model = new Participant();
        $model->tournament_id = $tournament_id;
        $model = $this->loadDefault($model);
        if ($model->load(Yii::$app->request->post())){
            if(!empty($model->player_id)){
                $player = Player::find()->where(['id' => $model->player_id])->one();
                $model->name = $player->name . $player->running_nr;
            }
            if($model->save()) {
                $model->tournament->setParticipantCount();
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
            } else {
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
            }

        } else if($bulk->load(Yii::$app->request->post())) {
            if(!empty($bulk->bulk)){
                $this->createParticipantsFromBulk($bulk);
            }
            if($bulk->save()) {
                $model->tournament->setParticipantCount();
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
            } else {
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
            }
        } else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'tournament' => $tournament,
                'source' => $source,
                'model' => $model,
                'bulk' => $bulk,
            ]);
        }
    }

    /**
     *
     * @param $bulk \yii\db\ActiveRecord frontend/models/Bulk
     */
    public function createParticipantsFromBulk($bulk){
        $participantArray = preg_split("/\r\n|\n|\r/", $bulk->bulk);
        foreach ($participantArray as $participant){
            $model = new Participant();
            $model->tournament_id = $bulk->tournament_id;
            $model->name = $participant;
            $model = $this->loadDefault($model);
            $model->save();
        }
    }


    /**
     * @param $tournament_id
     * @return string
     */
    public function actionStandings($tournament_id)
    {
        $searchModel = new ParticipantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $tournament_id, 1);
        $tournament = Tournament::find()->where(['id' => $tournament_id])->one();
        return $this->render('standings', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tournament' => $tournament,
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
        $model->seed = Participant::find()->where(['tournament_id' => $model->tournament_id])->count()+1;
        $model->rank = 0;
        $model->removed = 0;
        $model->on_waiting_list = 0;
        return $model;
    }

    public function actionShuffleSeeds($tournament_id){
        $participants = Participant::find()->where(['tournament_id' => $tournament_id])->all();
        $count = Participant::find()->where(['tournament_id' => $tournament_id])->count();
        $seeds = range(0, $count-1);
        shuffle($seeds);
        $newSeeds[]= null;
        $i = 0;
        foreach ($seeds as $number) {
            $newSeeds[$i] = $number;
            $i++;
        }
        $j = 0;
        foreach ($participants as $participant){
            $participant->seed = $newSeeds[$j];
            $j++;
            $participant->save();
        }
        return $this->redirect(['index', 'tournament_id' => $tournament_id]);

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
        $model = $this->findModel($id);
        $tournament_id = $model->tournament_id;
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'tournament_id' => $tournament_id]);
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
