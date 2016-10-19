<?php

namespace frontend\controllers;

use frontend\models\Bulk;
use frontend\models\ParticipantExternalSignupForm;
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
        $externalSignupModel = new ParticipantExternalSignupForm();
        $source[] = null;
        foreach (Player::find()->all() as $player){
            $object  = (object)[ 'label' => $player['nameWithRunningNr'], 'value' => $player['id']];
            $source[] = $object;
        }

        $bulk = new Bulk();
        $bulk->tournament_id = $tournament_id;
        /** @var Participant $model */
        $model = new Participant();
        $model->tournament_id = $tournament_id;
        $model = $this->loadDefault($model);
        if ($model->load(Yii::$app->request->post())){
            if($model->save()) {
                $model->tournament->setParticipantCount();
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
            } else {
                Yii::error($model->getErrors());
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
            }

        } else if($bulk->load(Yii::$app->request->post())) {
            if (!empty($bulk->bulk)) {
                $this->createParticipantsFromBulk($bulk);
            }
            if ($bulk->save()) {
                $model->tournament->setParticipantCount();
                Yii::$app->session->setFlash('success', 'Bulk with '.$bulk->bulk. ' are successfully registered!');
                $bulk->delete();
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
            } else {
                $bulk->delete();
                return $this->redirect(['index', 'tournament_id' => $model->tournament_id]);
            }
        } elseif ($externalSignupModel->load(Yii::$app->request->post()) && $externalSignupModel->validate()) {

            $model = $externalSignupModel->signup($model);
            if ($model->save()){
                $model->tournament->setParticipantCount();
                Yii::$app->session->setFlash('success', 'Hey '.$model->name. ', you are successfully registered!');
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
                'externalSignupModel' => $externalSignupModel,
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
            /** @var Participant $model */
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
        /** @var Tournament $tournament */
        $tournament = Tournament::find()->where(['id' => $tournament_id])->one();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $tournament_id, 1);
        $nulldataProvider = $searchModel->search(Yii::$app->request->queryParams, $tournament_id, 1, false);

        return $this->render('standings', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tournament' => $tournament,
            'nulldataProvider' => $nulldataProvider,
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
     * @param $tournament_id
     * @return mixed
     */
    public function actionSignup($tournament_id)
    {
        /** @var Participant $model */
        $model = new Participant();
        $model->tournament_id = $tournament_id;
        $model = $this->loadDefault($model);
        if ($model->load(Yii::$app->request->post())){
            if(!is_null($model->player_id)){
                /** @var Player $player */
                $player = Player::find()->where(['id' => $model->player_id])->one();
                if($player->running_nr == 1){
                    $model->name = $player->name;
                } else {
                    $model->name = $player->name . "#". $player->running_nr;
                }

            } else if(!is_null($model->team_id)){
                $team = Team::find()->where(['id' => $model->team_id])->one();
                $model->name = $team->name;
            } else if(is_null($model->team_id) && is_null($model->player_id)){
                Yii::$app->session->setFlash('error', 'Hey '.$model->name. ', you are successfully registered!');
            }
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Hey '.$model->name. ', you are successfully registered!');
                $model->tournament->setParticipantCount();
                return $this->redirect(['tournament/view', 'id' => $model->tournament_id]);
            } else {
                Yii::$app->session->setFlash('error', 'Something went wrong!');
                return $this->render('signup', [
                    'model' => $model,
                ]);
            }

        } else {

            return $this->render('signup', [
                'model' => $model,
            ]);
        }
    }

    public function loadDefault($model){
        $model->signup = 1;
        $model->seed = Participant::find()->where(['tournament_id' => $model->tournament_id])->count()+1;
        return $model;
    }

    public function actionShuffleSeeds($tournament_id){
        $participants = Participant::find()->where(['tournament_id' => $tournament_id])->all();
        $count = Participant::find()->where(['tournament_id' => $tournament_id])->count();
        $seeds = range(1, $count);
        shuffle($seeds);
        $newSeeds[]= null;
        $i = 1;
        foreach ($seeds as $number) {
            $newSeeds[$i] = $number;
            $i++;
        }
        $j = 1;
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
        $model->delete();
        /** @var Tournament $tournament */
        $tournament = Tournament::find()->where(['id' => $tournament_id])->one();
        $tournament->setParticipantCount();
        return $this->redirect(['index', 'tournament_id' => $tournament_id]);
    }

    /**
     * Deletes an existing Participant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCheckIn($id)
    {
        $model = $this->findModel($id);
        $tournament_id = $model->tournament_id;
        if($model->checked_in == Participant::CHECKED_IN_NO){
            $model->checked_in = Participant::CHECKED_IN_YES;
            Yii::$app->session->setFlash('success', 'Participant checked in.');
        } else {
            $model->checked_in = Participant::CHECKED_IN_NO;
            Yii::$app->session->setFlash('warning', 'Participant checked out.');
        }
        $model->save();
        /** @var Tournament $tournament */
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
    
    public function actionReorder($id, $order){

        $orderedIDArray = explode(',',$order);
        $seed = 1;
        foreach ($orderedIDArray as $participantId){
           /** @var Participant $participant */
            $participant = Participant::find()
               ->where(['tournament_id' => $id])
                ->andWhere(['id' => $participantId])
                ->one();
            $participant->seed = $seed;
            $participant->save();
            $seed++;
        }
        Yii::$app->session->setFlash('success', Yii::t('app', 'New seed order successfully saved.'));
        return $this->redirect(Yii::$app->request->referrer);

    }
    
}
