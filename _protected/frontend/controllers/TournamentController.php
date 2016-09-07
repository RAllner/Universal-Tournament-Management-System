<?php

namespace frontend\controllers;

use frontend\models\Participant;
use frontend\models\TournamentMatch;
use frontend\models\TournamentMatchSearch;
use yii;
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
     * @param int $filter
     * @return mixed
     */
    public function actionIndex($filter = 0)
    {
        $searchModel = new TournamentSearch();
        if (!isset($_GET['filter'])) {
            $_GET['filter'] = 0;
        }
        $time = new \DateTime('now');
        $today = $time->format('Y-m-d H:i:s');
        $allCount = Tournament::find()->count();
        $commingCount = Tournament::find()->where(['>=', 'begin', $today])
            ->andWhere(['not', ['status' => Tournament::STATUS_RUNNING]])
            ->count();
        $runningCount = Tournament::find()->where(['status' => 3])->count();
        $pastCount = Tournament::find()->where(['<=', 'begin', $today])
            ->andWhere(['not', ['status' => Tournament::STATUS_RUNNING]])
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
        $searchModel = new TournamentMatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id, Tournament::STAGE_FS, false);
        $treeDataProvider = $searchModel->search(Yii::$app->request->queryParams, $id, Tournament::STAGE_FS, true);
        $model = $this->findModel($id);
        $isFinalStage = ($model->stage_type == Tournament::STAGE_TYPE_SINGLE_STAGE) ? false : true;
        return $this->render('stage', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'treeDataProvider' => $treeDataProvider,
            'isFinalStage' => $isFinalStage,
        ]);
    }

    /**
     * Displays a Tournament Tree of the group stage if there is one.
     * @param integer $id
     * @return mixed
     */
    public function actionGroupStage($id)
    {

        $searchModel = new TournamentMatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id, Tournament::STAGE_GS, false);
        $treeDataProvider = $searchModel->search(Yii::$app->request->queryParams, $id, Tournament::STAGE_GS, true);
        $model = $this->findModel($id);
        $treeDataProviderArray = Array();
        for ($i = 1; $i <= $model->getGroupCount(); $i++) {
            $treeDataProviderArray[$i] = $searchModel->search(Yii::$app->request->queryParams, $id, Tournament::STAGE_GS, true, $i);
        }

        if ($model->stage_type === Tournament::STAGE_TYPE_TWO_STAGE) {
            return $this->render('groupStage', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'treeDataProvider' => $treeDataProvider,
                'treeDataProviderArray' => $treeDataProviderArray,
            ]);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'There is no Group Stage.'));
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }


    /**
     * Action is called when a match is reported
     *
     * @param $id
     * @return yii\web\Response
     */
    public function actionReportMatch($id)
    {
        $model = TournamentMatch::find()->where(['id' => $id])->one();
        /** @var $model TournamentMatch */
        if (Yii::$app->user->can('updateTournament', ['model' => $model])) {
            if ($model->load(Yii::$app->request->post())) {

                /** Check if the match is finished, and the results can be updated to the participants */
                if ((!is_null($model->winner_id) && !is_null($model->loser_id)) && ($model->winner_id != "") && ($model->loser_id != "")) {
                    $model->state = TournamentMatch::MATCH_STATE_FINISHED;


                    /** @var Participant $winnerParticipant */
                    $winnerParticipant = Participant::find()
                        ->where(['tournament_id' => $model->tournament_id])
                        ->andWhere(['id' => $model->winner_id])
                        ->one();
                    if (is_null($winnerParticipant->rank)) {
                        $winnerParticipant->rank = 'w';
                    } else {
                        $winnerParticipant->rank = $winnerParticipant->rank . ',w';
                    }
                    if (!$winnerParticipant->save()) {
                        Yii::$app->session->setFlash('error', $winnerParticipant->getErrors());
                    };

                    /** @var Participant $loserParticipant */
                    $loserParticipant = Participant::find()
                        ->where(['tournament_id' => $model->tournament_id])
                        ->andWhere(['id' => $model->loser_id])
                        ->one();
                    if (is_null($loserParticipant->rank)) {
                        $loserParticipant->rank = 'l';
                    } else {
                        $loserParticipant->rank = $loserParticipant->rank . ',l';
                    }
                    $loserParticipant->save();
                }

                if ($model->save()) {

                    /** if its not the last match update the follow matches */
                    if ($model->state == TournamentMatch::MATCH_STATE_FINISHED && (!is_null($model->follow_winner_and_loser_match_ids) && !empty($model->follow_winner_and_loser_match_ids) && !$model->follow_winner_and_loser_match_ids == "FS")) {
                        $winnerMatchID = explode(',', $model->follow_winner_and_loser_match_ids)[0];
                        if (count(explode(',', $model->follow_winner_and_loser_match_ids)) > 1) {
                            $loserMatchID = explode(',', $model->follow_winner_and_loser_match_ids)[1];
                            /** @var TournamentMatch $loserMatch */
                            $loserMatch = TournamentMatch::find()
                                ->where(['tournament_id' => $model->tournament_id])
                                ->andWhere(['stage' => $model->stage])
                                ->andWhere(['matchID' => $loserMatchID])
                                ->one();
                            /** set the loser as the upper or lower participant of the follow loser match*/
                            if (explode(',', $loserMatch->qualification_match_ids)[0] == $model->matchID) {
                                $loserMatch->participant_id_A = $model->loser_id;
                            } else {
                                $loserMatch->participant_id_B = $model->loser_id;
                            }
                            if (!is_null($loserMatch->participant_id_A) && !is_null($loserMatch->participant_id_B)) {
                                $loserMatch->state = TournamentMatch::MATCH_STATE_READY;
                            } else if (!is_null($loserMatch->participant_id_A) || !is_null($loserMatch->participant_id_B))
                                $loserMatch->state = TournamentMatch::MATCH_STATE_OPEN;
                            $loserMatch->save();
                        }

                        /** @var $winnerMatch TournamentMatch */
                        $winnerMatch = TournamentMatch::find()
                            ->where(['tournament_id' => $model->tournament_id])
                            ->andWhere(['stage' => $model->stage])
                            ->andWhere(['matchID' => $winnerMatchID])
                            ->one();

                        if (explode(',', $winnerMatch->qualification_match_ids)[0] == $model->matchID) {
                            $winnerMatch->participant_id_A = $model->winner_id;
                        } else {
                            $winnerMatch->participant_id_B = $model->winner_id;
                        }
                        if ((!is_null($winnerMatch->participant_id_A) && !is_null($winnerMatch->participant_id_B)) && (!empty($winnerMatch->participant_id_A) && !empty($winnerMatch->participant_id_B))) {
                            $winnerMatch->state = TournamentMatch::MATCH_STATE_READY;
                        } else if (!is_null($winnerMatch->participant_id_A) || !is_null($winnerMatch->participant_id_B))
                            $winnerMatch->state = TournamentMatch::MATCH_STATE_OPEN;
                        $winnerMatch->save();
                        /** Check if tournament is complete and can be finished */
                    } else if ($model->stage == Tournament::STAGE_FS && $model->state == TournamentMatch::MATCH_STATE_FINISHED && (is_null($model->follow_winner_and_loser_match_ids) || empty($model->follow_winner_and_loser_match_ids))) {

                        $unfinishedMatchesCount = TournamentMatch::find()
                            ->where(['tournament_id' => $model->tournament_id])
                            ->andWhere(['<', 'state', TournamentMatch::MATCH_STATE_FINISHED])
                            ->andWhere(['not', ['state' => TournamentMatch::MATCH_STATE_CREATED]])
                            ->count();
                        if ($unfinishedMatchesCount == 0) {
                            /** @var Tournament $tournament */
                            $tournament = Tournament::find()
                                ->where(['id' => $model->tournament_id])
                                ->one();
                            $tournament->status = Tournament::STATUS_COMPLETE;
                            if ($tournament->save()) {
                                Yii::$app->session->setFlash('info', Yii::t('app', 'Tournament is complete. You can finish it now.'));
                            }

                        }
                        /** Check if the group Stage is finished */
                    } else if ($model->stage == Tournament::STAGE_GS && $model->state == TournamentMatch::MATCH_STATE_FINISHED && ($model->follow_winner_and_loser_match_ids == "FS")) {
                        $unfinishedMatchesCount = TournamentMatch::find()
                            ->where(['tournament_id' => $model->tournament_id])
                            ->andWhere(['<', 'state', TournamentMatch::MATCH_STATE_FINISHED])
                            ->andWhere(['not', ['state' => TournamentMatch::MATCH_STATE_CREATED]])
                            ->andWhere(['stage' => Tournament::STAGE_GS])
                            ->count();
                        if ($unfinishedMatchesCount == 0) {
                            /** @var Tournament $tournament */
                            $tournament = Tournament::find()
                                ->where(['id' => $model->tournament_id])
                                ->one();
                            $tournament->status = Tournament::STATUS_GS_COMPLETE;
                            if ($tournament->save()) {
                                Yii::$app->session->setFlash('info', Yii::t('app', 'The Group stage is complete. You can start the final stage now.'));
                            }
                        }
                    }
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Sets the match state to "running"
     *
     * @param $id
     * @param $match_id
     * @return yii\web\Response
     */
    public function actionMatchRunning($id, $match_id)
    {
        /** @var TournamentMatch $match */
        $match = TournamentMatch::find()
            ->where(['tournament_id' => $id])
            ->andWhere(['id' => $match_id])
            ->one();
        if ($match->state == TournamentMatch::MATCH_STATE_READY) {
            $match->state = TournamentMatch::MATCH_STATE_RUNNING;
        } else {
            $match->state = TournamentMatch::MATCH_STATE_READY;
        }
        $match->save();
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     *
     * @param $id integer
     * @param $match_id integer
     * @return yii\web\Response
     */
    public function actionMatchUndo($id, $match_id)
    {
        /** Revert Changes TODO!*/
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Creates a new Tournament model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('createTournament')) {
            $model = new Tournament();
            $model = $this->loadDefault($model);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->hosted_by == -1) {
                    $model->user_id = Yii::$app->user->id;
                } else {
                    $model->organisation_id = $model->hosted_by;
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Check your input values');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->redirect('index');
        }
    }

    /**
     * Loads the default values for a tournament
     * @param $model Tournament;
     * @return Tournament
     */
    public function loadDefault($model)
    {
        $model->participants_compete = 4;
        $model->participants_advance = 2;
        $model->stage_type = 0;
        $model->fs_de_grand_finals = 0;
        return $model;
    }

    /**
     * Updates an existing Tournament model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /** @var TournamentController $this */
        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateTournament', ['model' => $model])) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->hosted_by == -1) {
                    $model->user_id = Yii::$app->user->id;
                } else {
                    $model->organisation_id = $model->hosted_by;
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Check your input values');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->redirect('index');
        }
    }


    /**
     * Deletes an existing Tournament model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /** @var TournamentController $this */
        $model = $this->findModel($id);
        if (Yii::$app->user->can('deleteTournament', ['model' => $model])) {
            $model->delete();
        }
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


    public function getParticipantCount($id)
    {
        return Participant::find()->where(['tournament_id' => $id])->count();
    }


    /** ----------------- Set tournament status ---------------------------- */

    /**
     * @param $id integer
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionPublish($id)
    {
        $model = $this->findModel($id);

        $model->status = Tournament::STATUS_PUBLISHED;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'The tournament now published.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Something went wrong.');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Action to start the tournament
     * @param $id integer
     * @return yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionStart($id)
    {
        if ($this->getParticipantCount($id) >= 2) {
            $model = $this->findModel($id);

            $model->status = ($model->stage_type == Tournament::STAGE_TYPE_SINGLE_STAGE) ? Tournament::STATUS_FINAL_STAGE : Tournament::STATUS_RUNNING;
            $stage = ($model->stage_type == Tournament::STAGE_TYPE_SINGLE_STAGE) ? Tournament::STAGE_FS : Tournament::STAGE_GS;
            if ($model->save()) {
                $this->createStage($model, $stage);
                return $this->redirect($redirect = ($model->stage_type == Tournament::STAGE_TYPE_SINGLE_STAGE) ? ['stage', 'id' => $id] : ['group-stage', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', 'Something went wrong.');
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Not enough participants to start the tournament');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * @param $id integer
     * @return yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionStartFinalStage($id)
    {
        /** @var Tournament $model */
        $model = $this->findModel($id);

        $unfinishedMatchesCount = TournamentMatch::find()
            ->where(['tournament_id' => $model->id])
            ->andWhere(['<', 'state', TournamentMatch::MATCH_STATE_FINISHED])
            ->andWhere(['not', ['state' => TournamentMatch::MATCH_STATE_CREATED]])
            ->andWhere(['stage' => Tournament::STAGE_GS])
            ->count();
        if ($unfinishedMatchesCount == 0) {
            $model->status = Tournament::STATUS_FINAL_STAGE;
            $stage = Tournament::STAGE_FS;
            if ($model->save()) {
                $this->createStage($model, $stage);
                return $this->redirect(['stage', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', 'Something went wrong.');
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Something went wrong.');
            return $this->redirect(['view', 'id' => $id]);
        }


    }

    /**
     * @param $id integer
     * @return yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAbort($id)
    {
        $model = $this->findModel($id);

        $model->status = Tournament::STATUS_ABORT;
        if ($model->save()) {
            Yii::$app->session->setFlash('info', 'The tournament is now aborted.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Something went wrong.');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * @param $id integer
     * @return yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionReset($id)
    {
        $model = $this->findModel($id);

        $model->status = Tournament::STATUS_PUBLISHED;
        /** @var Participant $participants */
        $participants = Participant::find()->where(['tournament_id' => $id])->all();
        foreach ($participants as $participant) {
            $participant->rank = null;
            $participant->save();
        }
        /** @var TournamentMatch $matches */
        $matches = TournamentMatch::find()->where(['tournament_id' => $id])->all();
        foreach ($matches as $match) {
            $match->delete();
        }
        if ($model->save()) {
            Yii::$app->session->setFlash('info', 'The tournament reset is finished.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            Yii::$app->session->setFlash('error', 'Something went wrong.');
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * @param $id
     * @return yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionFinish($id)
    {
        $model = $this->findModel($id);

        if ($model->status == Tournament::STATUS_COMPLETE) {
            $model->status = Tournament::STATUS_FINISHED;
            if ($model->save()) {
                Yii::$app->session->setFlash('info', 'The tournament is set to finished.');
                return $this->redirect(['view', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', 'Something went wrong.');
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('info', 'You can not finish a incomplete tournament.');
            return $this->redirect(['view', 'id' => $id]);
        }

    }

    /** ----------------- END Set tournament status ---------------------------- */


    /** ----------------- Crate Tournament Brackets ---------------------------- */


    /**
     *
     * @param $model Tournament
     */
    public
    function createStage($model, $stage)
    {
        if ($model->fs_format === Tournament::FORMAT_SINGLE_ELIMINATION) {
            $this->createSingleEliminationStage($model, $stage);
        } else if ($model->fs_format === Tournament::FORMAT_DOUBLE_ELIMINATION) {
            $this->createDoubleEliminationStage($model, $stage);
        } else if ($model->fs_format === Tournament::FORMAT_ROUND_ROBIN) {
            $this->createRoundRobinStage($model, $stage);
        } else {
            $this->createSwissStage($model, $stage);
        }
    }


    /**
     * @param $model Tournament
     * @param $stage integer
     */
    public
    function createSingleEliminationStage($model, $stage)
    {
        // Get the current time for the match timestamp
        $time = time();
        $tournament_id = $model->id;
        //$matchCount = $model->participants_count - 1;
        // Check if the stage is a group or final stage
        if ($stage == Tournament::STAGE_GS) {
            $groupCount = ceil($model->participants_count / $model->participants_compete);
            $matchesPerGroup = $model->participants_compete - $model->participants_advance;
            $maxRounds = ceil(log($model->participants_compete, 2));
            $maxMatches = pow(2, $maxRounds) - 1;
            $notPlayedRounds = log($model->participants_advance, 2);

            for ($group = 1; $group <= $groupCount; $group++) {
                $this->createSEBracket($maxRounds, $maxRounds, null, $maxMatches, $stage, $time, 1, $maxMatches, $tournament_id, 1, $group, $notPlayedRounds);
                $groupParticipantCount = $model->participants_compete;
                if ($group == $groupCount) {
                    $groupParticipantCount = $model->participants_count - (($groupCount - 1)*$model->participants_compete);
                }
                $this->clearSEBracketSeeds($model, $stage, $groupParticipantCount, $group);
                $this->fillParticipantIDs($model, $stage, $group);
            }
        }
        if ($stage == Tournament::STAGE_FS) {
            if ($model->stage_type == Tournament::STAGE_TYPE_SINGLE_STAGE) {
                $rounds = ceil(log($model->participants_count, 2));
                $maxMatches = pow(2, $rounds) - 1;

                $this->createSEBracket($rounds, $rounds, null, $maxMatches, $stage, $time, 1, $maxMatches, $tournament_id, 1, null, 0);
                $this->clearSEBracketSeeds($model, $stage, $model->participants_count, null);
                $this->fillParticipantIDs($model, $stage, null);
                if ($model->fs_third_place == 1 && $stage == Tournament::STAGE_FS) {
                    $this->createThirdPlaceMatch($rounds, $rounds, $maxMatches, $time, 1, $maxMatches, $tournament_id);
                }
            } else {
                $advancedParticipantCount = TournamentMatch::find()
                    ->where(['tournament_id' => $model->id])
                    ->andWhere(['stage' => Tournament::STAGE_GS])
                    ->andWhere(['follow_winner_and_loser_match_ids' => 'FS'])
                    ->andWhere(['state' => TournamentMatch::MATCH_STATE_FINISHED])
                    ->count();

                $rounds = ceil(log($advancedParticipantCount, 2));
                $maxMatches = pow(2, $rounds) - 1;

                $this->createSEBracket($rounds, $rounds, null, $maxMatches, $stage, $time, 1, $maxMatches, $tournament_id, 1, null, 0);
                $this->clearSEBracketSeeds($model, $stage, $advancedParticipantCount, null);
                $this->fillParticipantIDs($model, $stage, null);
                if ($model->fs_third_place == 1 && $stage == Tournament::STAGE_FS) {
                    $this->createThirdPlaceMatch($rounds, $rounds, $maxMatches, $time, 1, $maxMatches, $tournament_id);
                }
            }
        }
    }

    /**
     * @param $rounds integer
     * @param $currentRound integer
     * @param $id integer
     * @param $time integer
     * @param $innerRoundID integer
     * @param $maxMatches integer
     * @param $tournament_id integer
     * @internal param int $seed
     * @return bool
     */
    public
    function createThirdPlaceMatch($rounds, $currentRound, $id, $time, $innerRoundID, $maxMatches, $tournament_id)
    {
        $match = new TournamentMatch();
        $match->matchID = (string)(1 + $id);
        $match->stage = Tournament::STAGE_FS;
        $match->round = $currentRound;
        $match->follow_winner_and_loser_match_ids = null;
        $match->created_at = $time;
        $match->updated_at = $time;
        $match->tournament_id = $tournament_id;
        $match->losers_round = 1;

        $innerIdUpperChild = ($innerRoundID * 2) - 1;
        $innerIdLowerChild = ($innerRoundID * 2);
        $firstIndexOfRound = $maxMatches - (pow(2, $rounds - ($currentRound - 2)) - 1);
        $idUpperChild = $firstIndexOfRound + $innerIdUpperChild;
        $idLowerChild = $firstIndexOfRound + $innerIdLowerChild;
        $match->qualification_match_ids = $idUpperChild . ',' . $idLowerChild;
        $match->state = TournamentMatch::MATCH_STATE_OPEN;

        /** @var TournamentMatch $upperMatch */
        $upperMatch = TournamentMatch::find()
            ->where(['tournament_id' => $match->tournament_id])
            ->andWhere(['round' => $match->round - 1])
            ->andWhere(['matchID' => $idUpperChild])
            ->andWhere(['stage' => Tournament::STAGE_FS])
            ->one();
        $upperMatch->follow_winner_and_loser_match_ids = $upperMatch->follow_winner_and_loser_match_ids . ',' . $match->matchID;
        if (!$upperMatch->save()) {
            Yii::error($match->getErrors());
            Yii::$app->session->setFlash('error', "Something went terrible wrong" . $match->getErrors());
        }

        /** @var TournamentMatch $lowerMatch */
        $lowerMatch = TournamentMatch::find()
            ->where(['tournament_id' => $match->tournament_id])
            ->andWhere(['round' => $match->round - 1])
            ->andWhere(['matchID' => $idLowerChild])
            ->andWhere(['stage' => Tournament::STAGE_FS])
            ->one();
        $lowerMatch->follow_winner_and_loser_match_ids = $lowerMatch->follow_winner_and_loser_match_ids . ',' . $match->matchID;
        if (!$lowerMatch->save()) {
            Yii::error($match->getErrors());
            Yii::$app->session->setFlash('error', "Something went terrible wrong" . $match->getErrors());
        }

        if ($match->save()) {
            return true;
        } else {
            Yii::error($match->getErrors());
            Yii::$app->session->setFlash('error', "Something went terrible wrong" . $match->getErrors());
            return false;
        }
    }

    /**
     * Creates an empty Single Elimination Tree recursive
     *
     * @param $rounds integer
     * @param $currentRound integer
     * @param $fatherID integer
     * @param $id integer
     * @param $stage integer
     * @param $time integer
     * @param $innerRoundID integer
     * @param $maxMatches integer
     * @param $tournament_id integer
     * @param $seed integer
     * @param $group integer
     * @param $notPlayedRounds integer
     * @return bool
     */
    public
    function createSEBracket($rounds, $currentRound, $fatherID, $id, $stage, $time, $innerRoundID, $maxMatches, $tournament_id, $seed, $group, $notPlayedRounds)
    {
        /** @var TournamentMatch $match */
        $match = new TournamentMatch();
        $match->matchID = (string)$id;
        $match->groupID = $group;
        $match->stage = $stage;
        $match->round = $currentRound;
        $match->follow_winner_and_loser_match_ids = (string)$fatherID;
        $match->created_at = $time;
        $match->updated_at = $time;
        $match->tournament_id = $tournament_id;
        $difference = (2 * pow(2, $rounds - $currentRound)) + 1 - $seed;
        if ($seed % 2 == 0) {
            $match->seed_A = $difference;
            $match->seed_B = $seed;
        } else {
            $match->seed_A = $seed;
            $match->seed_B = $difference;
        }

        if ($currentRound == 1) {
            if ($match->save()) {
                return true;
            } else {
                Yii::error($match->getErrors());
                return false;
            }
        }
        $innerIdUpperChild = ($innerRoundID * 2) - 1;
        $innerIdLowerChild = ($innerRoundID * 2);
        $firstIndexOfRound = $maxMatches - (pow(2, $rounds - ($currentRound - 2)) - 1);
        $idUpperChild = $firstIndexOfRound + $innerIdUpperChild;
        $idLowerChild = $firstIndexOfRound + $innerIdLowerChild;
        $match->qualification_match_ids = $idUpperChild . ',' . $idLowerChild;

        if ($match->round <= $rounds - $notPlayedRounds) {
            $this->createSEBracket($rounds, $currentRound - 1, $id, $idUpperChild, $stage, $time, $innerIdUpperChild, $maxMatches, $tournament_id, $match->seed_A, $group, $notPlayedRounds);
            $this->createSEBracket($rounds, $currentRound - 1, $id, $idLowerChild, $stage, $time, $innerIdLowerChild, $maxMatches, $tournament_id, $match->seed_B, $group, $notPlayedRounds);
            if ($match->save()) {
                return true;
            } else {
                Yii::error($match->getErrors());
                Yii::$app->session->setFlash('error', "Something went terrible wrong" . $match->getErrors());
                return false;
            }
        } else {
            $this->createSEBracket($rounds, $currentRound - 1, "FS", $idUpperChild, $stage, $time, $innerIdUpperChild, $maxMatches, $tournament_id, $match->seed_A, $group, $notPlayedRounds);
            $this->createSEBracket($rounds, $currentRound - 1, "FS", $idLowerChild, $stage, $time, $innerIdLowerChild, $maxMatches, $tournament_id, $match->seed_B, $group, $notPlayedRounds);
            return true;
        }
    }

    /**
     * @param $model Tournament
     * @param $stage integer
     * @param $participant_count integer
     * @param $group integer
     */
    public
    function clearSEBracketSeeds($model, $stage, $participant_count, $group)
    {

        $rounds = ceil(log($participant_count, 2));
        //$maxMatches = pow(2, $rounds) - 1;
        $roundOneSize = pow(2, $rounds);
        $roundTwoSize = $roundOneSize / 2;
        $difference = $participant_count - $roundTwoSize;
        $roundTwoParticipants = $roundTwoSize - $difference;
        //$roundOneParticipants = $difference * 2;

        //First Round: delete all Seeds which are higher than ParticipantCount
        //Delete also the opponent, he is already waiting in the next round
        //TODO: SONDERFALL Nur ein Spieler in der Gruppe. Match erstellen und nicht beide seeds nullen State auf Ready
        if ($participant_count == 1) {
            $roundOneMatches = TournamentMatch::find()
                ->where(['or', ['seed_A' => $participant_count], ['seed_B' => $participant_count]])
                ->andWhere(['round' => 1])
                ->andWhere(['tournament_id' => $model->id])
                ->andWhere(['stage' => $stage])
                ->andWhere(['groupID' => $group])
                ->all();
            foreach ($roundOneMatches as $match) {
                /** @var $match TournamentMatch */
                $match->seed_B = null;
                $match->state = TournamentMatch::MATCH_STATE_FINISHED;
                $match->save();
            }
        } else {

            if($stage == Tournament::STAGE_GS){
                $roundOneMatchesA = TournamentMatch::find()
                    ->where(['>', 'seed_A', $participant_count])
                    ->andWhere(['round' => 1])
                    ->andWhere(['tournament_id' => $model->id])
                    ->andWhere(['stage' => $stage])
                    ->andWhere(['groupID' => $group])
                    ->all();
                foreach ($roundOneMatchesA as $match) {
                    /** @var $match TournamentMatch */
                    $match->seed_A = null;
                    $match->state = TournamentMatch::MATCH_STATE_FINISHED;
                    $match->save();
                }

                $roundOneMatchesB = TournamentMatch::find()
                    ->where(['>', 'seed_B', $participant_count])
                    ->andWhere(['round' => 1])
                    ->andWhere(['tournament_id' => $model->id])
                    ->andWhere(['stage' => $stage])
                    ->andWhere(['groupID' => $group])
                    ->all();
                foreach ($roundOneMatchesB as $match) {
                    /** @var $match TournamentMatch */
                    $match->seed_B = null;
                    $match->state = TournamentMatch::MATCH_STATE_FINISHED;
                    $match->save();
                }
            } else {
                $roundOneMatches = TournamentMatch::find()
                    ->where(['or', ['>', 'seed_A', $participant_count], ['>', 'seed_B', $participant_count]])
                    ->andWhere(['round' => 1])
                    ->andWhere(['tournament_id' => $model->id])
                    ->andWhere(['stage' => $stage])
                    ->andWhere(['groupID' => $group])
                    ->all();
                foreach ($roundOneMatches as $match) {
                    /** @var $match TournamentMatch */
                    $match->seed_A = null;
                    $match->seed_B = null;
                    $match->state = TournamentMatch::MATCH_STATE_CREATED;
                    $match->save();
                }
            }

        }


        // Delete all seeds in round 2 which are higher than the roundTwoParticipants
        // These participants are in round 1
        $roundTwoMatches_A = TournamentMatch::find()
            ->where(['>', 'seed_A', $roundTwoParticipants])
            ->andWhere(['round' => 2])
            ->andWhere(['tournament_id' => $model->id])
            ->andWhere(['stage' => $stage])
            ->andWhere(['groupID' => $group])
            ->all();
        foreach ($roundTwoMatches_A as $match) {
            /** @var $match TournamentMatch */
            $match->seed_A = null;
            $match->state = TournamentMatch::MATCH_STATE_OPEN;
            $match->save();
        }

        $roundTwoMatches_B = TournamentMatch::find()
            ->where(['>', 'seed_B', $roundTwoParticipants])
            ->andWhere(['round' => 2])
            ->andWhere(['tournament_id' => $model->id])
            ->andWhere(['stage' => $stage])
            ->andWhere(['groupID' => $group])
            ->all();
        foreach ($roundTwoMatches_B as $match) {
            /** @var $match TournamentMatch */
            $match->seed_B = null;
            $match->state = TournamentMatch::MATCH_STATE_OPEN;
            $match->save();
        }


        // Delete all seeds from matches from round 3 and higher. We don't need them.
        $roundThreeAndHigherMatches = TournamentMatch::find()
            ->where(['>', 'round', 2])
            ->andWhere(['tournament_id' => $model->id])
            ->andWhere(['stage' => $stage])
            ->andWhere(['groupID' => $group])
            ->all();

        foreach ($roundThreeAndHigherMatches as $match) {
            /** @var $match TournamentMatch */
            $match->seed_A = null;
            $match->seed_B = null;
            $match->state = TournamentMatch::MATCH_STATE_OPEN;
            $match->save();
        }

    }


    /**
     * Fill the bracket with Participants.
     * @param $model Tournament
     * @param $stage integer
     */
    public
    function fillParticipantIDs($model, $stage, $group)
    {

        // Fill in Participant IDs for Final Stage
        if ($stage == Tournament::STAGE_FS) {
            $openMatches = $this->getOpenMatches($model, $stage, null);
            // Is the tournament a two stage tournament?
            if ($model->stage_type == Tournament::STAGE_TYPE_TWO_STAGE) {
                // yes!
                /**
                 * @var  $seed integer
                 * @var  $participant Participant
                 */
                $seedMap = array();
                foreach ($this->getAdvancedParticipants($model) as $seed => $participant) {
                    $seedMap[$seed] = $participant->id;
                }
                foreach ($openMatches as $match) {
                    /** @var $match TournamentMatch */
                    if (!is_null($match->seed_A) && !is_null($match->seed_B)) {
                        /** @var Participant $participant_A */

                        $match->participant_id_A = $seedMap[$match->seed_A - 1];
                        $match->participant_id_B = $seedMap[$match->seed_B - 1];
                        $match->state = TournamentMatch::MATCH_STATE_READY;
                    }
                    if (!is_null($match->seed_A)) {
                        $match->participant_id_A = $seedMap[$match->seed_A - 1];
                        $match->save();
                    }
                    if (!is_null($match->seed_B)) {
                        $match->participant_id_B = $seedMap[$match->seed_B - 1];
                        $match->save();
                    }
                }
            } else {
                // no!
                foreach ($openMatches as $match) {
                    /** @var $match TournamentMatch */
                    if (!is_null($match->seed_A) && !is_null($match->seed_B)) {
                        /** @var Participant $participant_A */
                        $participant_A = Participant::find()
                            ->where(['tournament_id' => $model->id])
                            ->andWhere(['seed' => $match->seed_A])
                            ->one();

                        /** @var Participant $participant_B */
                        $participant_B = Participant::find()
                            ->where(['tournament_id' => $model->id])
                            ->andWhere(['seed' => $match->seed_B])
                            ->one();
                        $match->participant_id_A = $participant_A->id;
                        $match->participant_id_B = $participant_B->id;
                        $match->state = TournamentMatch::MATCH_STATE_READY;
                    }
                    if (!is_null($match->seed_A)) {
                        /** @var Participant $participant */
                        $participant = Participant::find()
                            ->where(['tournament_id' => $model->id])
                            ->andWhere(['seed' => $match->seed_A])
                            ->one();
                        $match->participant_id_A = $participant->id;
                        $match->save();
                    }
                    if (!is_null($match->seed_B)) {
                        /** @var Participant $participant */
                        $participant = Participant::find()
                            ->where(['tournament_id' => $model->id])
                            ->andWhere(['seed' => $match->seed_B])
                            ->one();
                        $match->participant_id_B = $participant->id;
                        $match->save();
                    }
                }
            }
            // Fill in Participant IDs for Group Stage
        } else {
            $openMatches = $this->getOpenMatches($model, $stage, $group);
            $seedGroupOffset = ($group - 1) * $model->participants_compete;
            foreach ($openMatches as $match) {
                /** @var $match TournamentMatch */

                // If both seeds are entered, the match can be set to ready
                if (!is_null($match->seed_A) && !is_null($match->seed_B)) {
                    /** @var Participant $participant_A */
                    $participant_A = Participant::find()
                        ->where(['tournament_id' => $model->id])
                        ->andWhere(['seed' => $match->seed_A + $seedGroupOffset])
                        ->one();

                    /** @var Participant $participant_B */
                    $participant_B = Participant::find()
                        ->where(['tournament_id' => $model->id])
                        ->andWhere(['seed' => $match->seed_B + $seedGroupOffset])
                        ->one();
                    $match->participant_id_A = $participant_A->id;
                    $match->participant_id_B = $participant_B->id;
                    $match->state = TournamentMatch::MATCH_STATE_READY;
                }
                //TODO: SONDERFALL Nur ein Spieler in der Gruppe: Match finden bei dem trotz einem einzelnen Spieler State Finish ist ist state auf finished und participant einfügen
                if (!is_null($match->seed_A)) {
                    /** @var Participant $participant */
                    $participant = Participant::find()
                        ->where(['tournament_id' => $model->id])
                        ->andWhere(['seed' => $match->seed_A + $seedGroupOffset])
                        ->one();
                    if($match->state == TournamentMatch::MATCH_STATE_FINISHED){
                        $match->winner_id = $participant->id;
                    }
                    $match->participant_id_A = $participant->id;
                    $match->save();
                }
                if (!is_null($match->seed_B)) {
                    /** @var Participant $participant */
                    $participant = Participant::find()
                        ->where(['tournament_id' => $model->id])
                        ->andWhere(['seed' => $match->seed_B + $seedGroupOffset])
                        ->one();
                    if($match->state == TournamentMatch::MATCH_STATE_FINISHED){
                        $match->winner_id = $participant->id;
                    }
                    $match->participant_id_B = $participant->id;
                    $match->save();
                }
            }
        }
    }

    /**
     * @param $model Tournament
     * @param $stage integer
     */
    public
    function setSEMatchIDs($model, $stage)
    {
        $openMatches = $this->getAllTournamentMatches($model, $stage);

        $i = 1;
        foreach ($openMatches as $match) {
            /** @var $match TournamentMatch */
            $match->matchID = (string)$i;
            $match->save();
            $i++;
        }
    }

    /**
     * @param $model Tournament
     * @return array|yii\db\ActiveRecord[]
     */
    public
    function getAdvancedParticipants($model)
    {
        /** @var yii\db\ActiveRecord[] $matches */
        $matches = TournamentMatch::find()
            ->where(['tournament_id' => $model->id])
            ->andWhere(['stage' => Tournament::STAGE_GS])
            ->andWhere(['state' => TournamentMatch::MATCH_STATE_FINISHED])
            ->andWhere(['follow_winner_and_loser_match_ids' => "FS"])
            ->all();
        $winnerIDs = null;
        /** @var TournamentMatch $match */
        foreach ($matches as $match) {
            $winnerIDs[] = $match->winner_id;
        }
        return Participant::find()
            ->where(['tournament_id' => $model->id])
            ->andWhere(['id' => $winnerIDs])
            ->all();


    }

    /**
     * @param $model Tournament
     * @param $stage integer
     * @return array|yii\db\ActiveRecord[]
     */
    public
    function getOpenMatches($model, $stage, $group)
    {
        return TournamentMatch::find()
            ->where(['not', ['and', ['seed_A' => null], ['seed_B' => null]]])
            ->andWhere(['tournament_id' => $model->id])
            ->andWhere(['stage' => $stage])
            ->andWhere(['groupID' => $group])
            ->all();
    }

    public
    function getAllTournamentMatches($model, $stage)
    {
        return TournamentMatch::find()
            ->where(['not', ['and', ['seed_A' => null], ['seed_B' => null]]])
            ->orWhere(['>', 'round', 1])
            ->andWhere(['tournament_id' => $model->id])
            ->andWhere(['stage' => $stage])
            ->all();
    }

    /**
     * @param $model Tournament
     * @param $stage integer
     */
    public
    function createDoubleEliminationStage($model, $stage)
    {

    }

    /**
     * @param $model Tournament
     * @param $stage integer
     */
    public
    function createRoundRobinStage($model, $stage)
    {

    }

    /**
     * @param $model Tournament
     * @param $stage integer
     */
    public
    function createSwissStage($model, $stage)
    {

    }

    public
    function calculateAdvancingParticipants($model)
    {

    }

    /**
     * @param $model Tournament
     */
    public
    function calculateGroupCount($model)
    {
        return ceil($model->participants_count / $model->participants_compete);
    }


    /** ----------------- END Crate Tournament Brackets ------------------------ */

}
