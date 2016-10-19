<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%participant}}".
 *
 * @property integer $id
 * @property integer $tournament_id
 * @property integer $signup
 * @property integer $checked_in
 * @property string $name
 * @property string $mail
 * @property integer $seed
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $rank
 * @property string $history
 * @property integer $elo
 * @property integer $player_id
 * @property integer $team_id
 * @property integer $removed
 * @property integer $on_waiting_list
 *
 * @property TournamentMatch[] $matches
 * @property TournamentMatch[] $matches0
 * @property Tournament $tournament
 */
class Participant extends ActiveRecord
{
    const CHECKED_IN_YES = 1;
    const CHECKED_IN_NO = 0;

    const SIGNUP_STATUS_INTERNAL_ADMIN = 0;
    const SIGNUP_STATUS_INTERNAL_TEAM = 1;
    const SIGNUP_STATUS_INTERNAL_PLAYER = 2;
    const SIGNUP_STATUS_EXTERNAL = 3;


    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%participant}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tournament_id', 'name'], 'required'],
            [['name', 'email'],  'filter', 'filter' => 'trim'],
            [['tournament_id', 'signup', 'checked_in', 'seed', 'updated_at', 'created_at', 'rank', 'elo' ,'player_id', 'team_id', 'removed', 'on_waiting_list'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['email', 'email'],
            [['history'], 'string', 'max' => 512],
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
            'signup' => Yii::t('app', 'Signup'),
            'checked_in' => Yii::t('app', 'Checked In'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'seed' => Yii::t('app', 'Seed'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'rank' => Yii::t('app', 'Rank'),
            'history' => Yii::t('app', 'Match History'),
            'elo' => Yii::t('app', 'Elo Rating'),
            'player_id' => Yii::t('app', 'Player ID'),
            'team_id' => Yii::t('app', 'Team ID'),
            'removed' => Yii::t('app', 'Removed'),
            'on_waiting_list' => Yii::t('app', 'On Waiting List'),
        ];
    }

    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches()
    {
        return $this->hasMany(TournamentMatch::className(), ['participant_id_A' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches0()
    {
        return $this->hasMany(TournamentMatch::className(), ['participant_id_B' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
    }

    public function getPlayers()
    {
        $TournamentParticipants = Participant::find()
            ->where(['tournament_id' => $this->tournament_id])
            ->andWhere(['not', ['player_id' => null]])
            ->all();
        $player_idString = Array();
        $tmp = "";
        /** @var Participant $participant */
        foreach ($TournamentParticipants as $participant) {
            array_push($player_idString, $participant->player_id);
            $tmp .= $participant->player_id;
        }
        //Yii::$app->session->setFlash('error', $player_idString[0]);
        if(empty($tmp)){
            return Player::find()
                ->andWhere(['user_id' => Yii::$app->user->id])
                ->all();
        } else {
            return Player::find()
                ->andWhere(['user_id' => Yii::$app->user->id])
                ->andWhere(['not in', 'id', $player_idString])
                ->all();
        }
    }

    public function getTeams()
    {
        $tournament_id = $this->tournament->id;
        $currentParticipants = Participant::find()->where(['tournament_id' => $tournament_id])
                ->andWhere(['not',['team_id' => null]])
                ->all();
        $team_ids[] = '-1';
        foreach ($currentParticipants as $participant){
            $team_ids[] = $participant->team_id;
        }
        $teams = null;
        foreach ($this->getPlayers() as $player) {
            $teamMembers = TeamMember::find()->where(['player_id' => $player->id, 'admin' => 1])
                ->andWhere(['not',['team_id' => $team_ids]])
                ->all();
            $i = 0;
            foreach ($teamMembers as $teamMember) {
                if ($i == 0) {
                    $teams = array(Team::find()->where(['id' => $teamMember->team_id])->one());
                } else {
                    array_push($teams, Team::find()->where(['id' => $teamMember->team_id])->one());
                }
                $i++;
            }
        }
        return $teams;
    }

    public function getPlayerName()
    {
        if (isset($this->player_id)) {
            $player = Player::find()->where(['id' => $this->player_id])->one();
            return $player->name;
        } else return "";
    }

    public function getTeamName()
    {
        if (isset($this->team_id)) {
            $team = Team::find()->where(['id' => $this->team_id])->one();
            return $team->name;
        } else return "";
    }

    public function getTournamentName()
    {
        return $this->tournament->name;
    }


    /**
     * Calculates the match wins of a tournament participant
     * @return int
     */
    public function getMatchWins(){
        $winCounter = 0;
        $participantAWins = TournamentMatch::find()
            ->where(['tournament_id' => $this->tournament_id])
            ->andWhere(['participant_id_A' => $this->id])
            ->andWhere(['state' => TournamentMatch::MATCH_STATE_FINISHED])
            ->all();
        /** @var TournamentMatch $match */
        foreach ($participantAWins as $match){
            $tmpArray = explode(',',$match->scores);
            /** @var string $score */
            foreach ($tmpArray as $score){
                $winCounter = $winCounter + intval(explode('-',$score)[0]);
            }
        }
        $participantBWins = TournamentMatch::find()
            ->where(['tournament_id' => $this->tournament_id])
            ->andWhere(['participant_id_B' => $this->id])
            ->andWhere(['state' => TournamentMatch::MATCH_STATE_FINISHED])
            ->all();
        /** @var TournamentMatch $match */
        foreach ($participantBWins as $match){
            $tmpArray = explode(',',$match->scores);
            /** @var string $score */
            foreach ($tmpArray as $score){
                $winCounter = $winCounter + intval(explode('-',$score)[1]);
            }
        }
        return $winCounter;
    }

    /**
     * Calculates the match losses of a tournament participant
     * @return int
     */
    public function getMatchLosses(){
        $lossCounter = 0;
        $participantAWins = TournamentMatch::find()
            ->where(['tournament_id' => $this->tournament_id])
            ->andWhere(['participant_id_A' => $this->id])
            ->andWhere(['state' => TournamentMatch::MATCH_STATE_FINISHED])
            ->all();
        /** @var TournamentMatch $match */
        foreach ($participantAWins as $match){
            $tmpArray = explode(',',$match->scores);
            /** @var string $score */
            foreach ($tmpArray as $score){
                $lossCounter = $lossCounter + intval(explode('-',$score)[1]);
            }
        }
        $participantBWins = TournamentMatch::find()
            ->where(['tournament_id' => $this->tournament_id])
            ->andWhere(['participant_id_B' => $this->id])
            ->andWhere(['state' => TournamentMatch::MATCH_STATE_FINISHED])
            ->all();
        /** @var TournamentMatch $match */
        foreach ($participantBWins as $match){
            $tmpArray = explode(',',$match->scores);
            /** @var string $score */
            foreach ($tmpArray as $score){
                $lossCounter = $lossCounter + intval(explode('-',$score)[0]);
            }
        }
        return $lossCounter;
    }

    public function getParticipantImage()
    {
        if(!is_null($this->player_id)){
            /** @var Player $player */
            $player = Player::find()
                ->where(['id' => $this->player_id])
                ->one();
            return $player->getPhotoInfo();
        } elseif (!is_null($this->team_id)){
            /** @var Team $team */
            $team = Team::find()
                ->where(['id' => $this->team_id])
                ->one();
            return $team->getPhotoInfo();
        } else {
            $url = Url::to('@web/images/players/');
            $alt = $this->name;
            $imageInfo = ['alt' => $alt];
            $imageInfo['url'] = $url . 'default.jpg';
            return $imageInfo;
        }
    }
}

?>


