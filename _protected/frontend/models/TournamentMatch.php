<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%tournament_match}}".
 *
 * @property integer $id
 * @property integer $tournament_id
 * @property integer $stage
 * @property string $matchID
 * @property integer $groupID
 * @property integer $round
 * @property integer $participant_id_A
 * @property integer $participant_score_A
 * @property integer $seed_A
 * @property integer $participant_id_B
 * @property integer $participant_score_B
 * @property string $scores
 * @property integer $seed_B
 * @property integer $winner_id
 * @property integer $loser_id
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $begin_at
 * @property string $finished_at
 * @property resource $metablob
 * @property integer $state
 * @property string $follow_winner_and_loser_match_ids
 * @property string $qualification_match_ids
 * @property integer $losers_round
 *
 * @property Tournament $tournament
 */
class TournamentMatch extends ActiveRecord
{

    const MATCH_STATE_CREATED = 0;
    const MATCH_STATE_OPEN = 1;
    const MATCH_STATE_READY = 2;
    const MATCH_STATE_RUNNING = 3;
    const MATCH_STATE_FINISHED = 4;
    const MATCH_STATE_DIRECT_ADVANCE = 5;

    const WINNERS_BRACKET = 0;
    const LOSERS_BRACKET = 1;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tournament_match}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tournament_id', 'stage', 'updated_at', 'created_at'], 'required'],
            [['tournament_id', 'stage', 'seed_A', 'seed_B', 'groupID', 'round', 'participant_id_A', 'participant_score_A', 'participant_id_B', 'participant_score_B', 'winner_id', 'loser_id', 'updated_at', 'created_at', 'state', 'losers_round'], 'integer'],
            [['begin_at', 'finished_at'], 'safe'],
            [['metablob'], 'string'],
            [['matchID'], 'string', 'max' => 11],
            [['follow_winner_and_loser_match_ids', 'qualification_match_ids', 'scores'], 'string', 'max' => 512],
            [['tournament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournament::className(), 'targetAttribute' => ['tournament_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tournament_id' => Yii::t('app', 'Tournament ID'),
            'stage' => Yii::t('app', 'Stage'),
            'matchID' => Yii::t('app', 'Match ID'),
            'groupID' => Yii::t('app', 'Group ID'),
            'round' => Yii::t('app', 'Round'),
            'participant_id_A' => Yii::t('app', 'Participant Id  A'),
            'participant_score_A' => Yii::t('app', 'Participant Score  A'),
            'seed_A' => Yii::t('app', 'Seed A'),
            'participant_id_B' => Yii::t('app', 'Participant Id  B'),
            'participant_score_B' => Yii::t('app', 'Participant Score  B'),
            'scores' => Yii::t('app', 'Scores'),
            'seed_B' => Yii::t('app', 'Seed B'),
            'winner_id' => Yii::t('app', 'Winner ID'),
            'loser_id' => Yii::t('app', 'Loser ID'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'begin_at' => Yii::t('app', 'Begin At'),
            'finished_at' => Yii::t('app', 'Finished At'),
            'metablob' => Yii::t('app', 'Metablob'),
            'state' => Yii::t('app', 'State'),
            'follow_winner_and_loser_match_ids' => Yii::t('app', 'Follow Winner And Loser Match Ids'),
            'qualification_match_ids' => Yii::t('app', 'Qualification Match Ids'),
            'losers_round' => Yii::t('app', 'Losers Round'),
        ];
    }

    /**
     * Returns the match stage in nice format.
     *
     * @param null $stage
     * @return string Nicely formatted stage.
     *
     */
    public function getBracketName($stage = null)
    {
        $stage = (empty($stage)) ? $this->stage : $stage;

        if ($stage === self::WINNERS_BRACKET) {
            return Yii::t('app', 'Winners Bracket');
        } else {
            return Yii::t('app', 'Losers Bracket');
        }
    }


    /**
     * Returns the tournaments status in nice format.
     *
     * @param  null|integer $state Status integer value if sent to method.
     * @return string               Nicely formatted status.
     */
    public function getStateName($state= null)
    {
        $state = (empty($state)) ? $this->$state : $state;

        if ($state === self::MATCH_STATE_CREATED) {
            return Yii::t('app', 'Created');
        } else if ($state === self::MATCH_STATE_OPEN) {
            return Yii::t('app', 'Open');
        } else if ($state === self::MATCH_STATE_READY) {
            return Yii::t('app', 'Ready');
        } else if ($state === self::MATCH_STATE_RUNNING) {
            return Yii::t('app', 'Running');
        } else if ($state === self::MATCH_STATE_FINISHED) {
            return Yii::t('app', 'Finished');
        } else  {
            return Yii::t('app', 'Direct advance');
        }
    }



    /**
     * Returns the match stage in nice format.
     *
     * @param null $round
     * @param $tournament Tournament
     * @return string Nicely formatted stage.
     *
     */
    public function getRoundName($round = null, $tournament, $losers_round)
    {
        $round = (empty($round)) ? $this->round : $round;
        $rounds = ceil(log($tournament->participants_count, 2));
        if ($losers_round == 0) {

            if ($round == $rounds) {
                return Yii::t('app', 'Final');
            } else if ($round == $rounds - 1) {
                return Yii::t('app', 'Semifinal');
            } else {
                return Yii::t('app', 'Round') . ' ' . $round;
            }
        } else {
            $rounds = ($rounds * 2) - 2;
            if ($round == $rounds) {
                return Yii::t('app', 'Losers Final');
            } else if ($round == $rounds - 1) {
                return Yii::t('app', 'Losers Semifinal');
            } else {
                return Yii::t('app', 'Losers Round') . ' ' . $round;
            }
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
    }

    /**
     * Returns the participant names depending on the participant id of the match
     * @return array Participant_A Name [0] Participant_B Name [1]
     */
    public function getParticipantNames()
    {
        $participant_A = Participant::find()->where(['id' => $this->participant_id_A])->one();

        $winnerOf = Yii::t('app', 'Winner of');
        $LoserOf = Yii::t('app', 'Loser of');


        /** @var Participant $participant_A */
        if (isset($participant_A)) {
            $participant_A_Name = $participant_A->name;
        } else {
            $tmpArray = explode(',', $this->qualification_match_ids);
            /** @var TournamentMatch $qualifyingUpperMatch */
            $qualifyingUpperMatch = TournamentMatch::find()
                ->where(['matchID' => $tmpArray[0]])
                ->andWhere(['tournament_id' => $this->tournament_id])
                ->andWhere(['groupID' => $this->groupID])
                ->one();
            if (!is_null($qualifyingUpperMatch)) {
                if ($qualifyingUpperMatch->losers_round == 0) {
                    if ($tmpArray[0] != "0" && $this->losers_round == 0) {
                        $participant_A_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[0];
                    } else if ($tmpArray[0] != "0" && $this->losers_round == 1) {
                        $participant_A_Name = Yii::t('app', 'Loser of') . " " . $tmpArray[0];
                    } else {
                        $participant_A_Name = "";
                    }
                } else {
                    if ($tmpArray[0] != "0" && $this->losers_round == 1) {
                        $participant_A_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[0];
                    } else {
                        $participant_A_Name = "";
                    }
                }
            } else {
                if ($tmpArray[0] != "0" && $this->losers_round == 0) {
                    $participant_A_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[0];
                } else if ($tmpArray[0] != "0" && $this->losers_round == 1) {
                    $participant_A_Name = Yii::t('app', 'Loser of') . " " . $tmpArray[0];
                } else {
                    $participant_A_Name = "";
                }
            }

        }

        $participant_B = Participant::find()->where(['id' => $this->participant_id_B])->one();
        /** @var Participant $participant_B */
        if (isset($participant_B)) {
            $participant_B_Name = $participant_B->name;
        } else {
            $tmpArray = explode(',', $this->qualification_match_ids);

            if (count($tmpArray) > 1) {
                /** @var TournamentMatch $qualifyingLowerMatch */
                $qualifyingLowerMatch = TournamentMatch::find()
                    ->where(['matchID' => $tmpArray[1]])
                    ->andWhere(['tournament_id' => $this->tournament_id])
                    ->andWhere(['groupID' => $this->groupID])
                    ->one();
                if (!is_null($qualifyingLowerMatch)) {
                    if ($qualifyingLowerMatch->losers_round == 0) {
                        if ($tmpArray[0] != "0" && $this->losers_round == 0) {
                            $participant_B_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[1];
                        } else if ($tmpArray[0] != "0" && $this->losers_round == 1) {
                            $participant_B_Name = Yii::t('app', 'Loser of') . " " . $tmpArray[1];
                        } else {
                            $participant_B_Name = "";
                        }
                    } else {
                        if ($tmpArray[0] != "0" && $this->losers_round == 1) {
                            $participant_B_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[1];
                        } else {
                            $participant_B_Name = "";
                        }
                    }
                } else {
                    if ($tmpArray[0] != "0" && $this->losers_round == 0) {
                        $participant_B_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[1];
                    } else if ($tmpArray[0] != "0" && $this->losers_round == 1) {
                        $participant_B_Name = Yii::t('app', 'Loser of') . " " . $tmpArray[1];
                    } else {
                        $participant_B_Name = "";
                    }
                }
            } else {
                $participant_B_Name = "";
            }
        }
        return ['A' => $participant_A_Name, 'B' => $participant_B_Name];
    }

    public function getParticipantAImage(){

        if($this->participant_id_A !== 0){
            /** @var Participant $participant_A */
            $participant_A = Participant::find()
                ->where(['id' => $this->participant_id_A])
                ->one();
            return $participant_A->getParticipantImage();
        } else {
            $url = Url::to('@web/images/players/');
            $alt = $this->id;
            $imageInfo = ['alt' => $alt];
            $imageInfo['url'] = $url . 'default.jpg';
            return $imageInfo;
        }
    }

    public function getParticipantBImage(){

        if($this->participant_id_B !== 0){
            /** @var Participant $participant_B */
            $participant_B = Participant::find()
                ->where(['id' => $this->participant_id_B])
                ->one();
            return $participant_B->getParticipantImage();
        } else {
            $url = Url::to('@web/images/players/');
            $alt = $this->id;
            $imageInfo = ['alt' => $alt];
            $imageInfo['url'] = $url . 'default.jpg';
            return $imageInfo;
        }
    }


}
