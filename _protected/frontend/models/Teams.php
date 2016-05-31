<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teams".
 *
 * @property integer $idteams
 * @property string $name
 * @property string $website
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $description
 * @property integer $user_id
 *
 * @property PlayersHasTeams[] $playersHasTeams
 * @property Players[] $playersIdplayers
 * @property TeamMatches[] $teamMatches
 * @property TeamMatches[] $teamMatches0
 * @property TeamTournamentsHasTeams[] $teamTournamentsHasTeams
 * @property User $user
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idteams', 'user_id'], 'required'],
            [['idteams', 'updated_at', 'created_at', 'user_id'], 'integer'],
            [['description'], 'string'],
            [['name', 'website'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idteams' => Yii::t('app', 'Idteams'),
            'name' => Yii::t('app', 'Name'),
            'website' => Yii::t('app', 'Website'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'description' => Yii::t('app', 'Description'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayersHasTeams()
    {
        return $this->hasMany(PlayersHasTeams::className(), ['teams_idteams' => 'idteams']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayersIdplayers()
    {
        return $this->hasMany(Players::className(), ['idplayers' => 'players_idplayers'])->viaTable('players_has_teams', ['teams_idteams' => 'idteams']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamMatches()
    {
        return $this->hasMany(TeamMatches::className(), ['teams_idteamA' => 'idteams']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamMatches0()
    {
        return $this->hasMany(TeamMatches::className(), ['teams_idteamB' => 'idteams']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamTournamentsHasTeams()
    {
        return $this->hasMany(TeamTournamentsHasTeams::className(), ['teams_idteams' => 'idteams']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
