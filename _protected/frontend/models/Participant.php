<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%participant}}".
 *
 * @property integer $id
 * @property integer $tournament_id
 * @property integer $signup
 * @property integer $checked_in
 * @property string $name
 * @property integer $seed
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $rank
 * @property integer $player_id
 * @property integer $team_id
 * @property integer $removed
 * @property integer $on_waiting_list
 *
 * @property Match[] $matches
 * @property Match[] $matches0
 * @property Tournament $tournament
 */
class Participant extends ActiveRecord
{
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
            [['tournament_id', 'signup', 'checked_in', 'seed', 'updated_at', 'created_at', 'rank', 'player_id', 'team_id', 'removed', 'on_waiting_list'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'seed' => Yii::t('app', 'Seed'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'rank' => Yii::t('app', 'Rank'),
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
        return $this->hasMany(Match::className(), ['participant_id_A' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches0()
    {
        return $this->hasMany(Match::className(), ['participant_id_B' => 'id']);
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
        return Player::find()->where(['user_id' => Yii::$app->user->id])->all();
    }

    public function getTeams()
    {
        foreach ($this->getPlayers() as $player) {
            $teamMembers = TeamMember::find()->where(['player_id' => $player->id, 'admin' => 1])->all();
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


}

?>


