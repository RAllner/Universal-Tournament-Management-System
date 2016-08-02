<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

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

    const STAGE_WINNERS_STAGE = 0;
    const STAGE_LOSERS_STAGE = 1;



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
    public function getStageName($stage = null)
    {
        $stage = (empty($stage)) ? $this->stage : $stage;

        if ($stage === self::STAGE_WINNERS_STAGE) {
            return Yii::t('app', 'Winners Stage');
        } else {
            return Yii::t('app', 'Losers Stage');
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
        if($losers_round == 0){
            if ($round == $rounds) {
                return Yii::t('app', 'Final');
            } else if($round == $rounds-1) {
                return Yii::t('app', 'Semifinal');
            } else {
                return Yii::t('app', 'Round'). ' '. $round;
            }
        } else {
            if ($round == $rounds) {
                return Yii::t('app', 'Losers Final');
            } else if($round == $rounds-1) {
                return Yii::t('app', 'Losers Semifinal');
            } else {
                return Yii::t('app', 'Losers Round'). ' '. $round;
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
    public function getParticipantNames(){
        $participant_A = Participant::find()->where(['id' => $this->participant_id_A])->one();
        /** @var Participant $participant_A */
        if (isset($participant_A)) {
            $participant_A_Name = $participant_A->name;
        } else {
            $tmpArray = explode(',', $this->qualification_match_ids);
            if ($tmpArray[0] != "0"  && $this->losers_round == 0) {
                $participant_A_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[0];
            }else if($tmpArray[0] != "0"  && $this->losers_round == 1){
                $participant_A_Name = Yii::t('app', 'Loser of') . " " . $tmpArray[0];
            } else {
                $participant_A_Name = "";
            }
        }

        $participant_B = Participant::find()->where(['id' => $this->participant_id_B])->one();
        /** @var Participant $participant_B */
        if (isset($participant_B)) {
            $participant_B_Name = $participant_B->name;
        } else {
            $tmpArray = explode(',', $this->qualification_match_ids);
            if (count($tmpArray) > 1 && $this->losers_round == 0) {
                $participant_B_Name = Yii::t('app', 'Winner of') . " " . $tmpArray[1];
            } else if(count($tmpArray) > 1 && $this->losers_round == 1) {
                $participant_B_Name = Yii::t('app', 'Loser of') . " " . $tmpArray[1];
            }else {
                $participant_B_Name = "";
            }
        }
        return ['A' => $participant_A_Name, 'B' => $participant_B_Name];
    }

}
