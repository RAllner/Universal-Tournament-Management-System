<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "players".
 *
 * @property integer $idplayers
 * @property string $name
 * @property integer $running_nr
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 *
 * @property Matches[] $matches
 * @property Matches[] $matches0
 * @property User $user
 * @property PlayersHasTeams[] $playersHasTeams
 * @property Teams[] $teamsIdteams
 * @property Signups[] $signups
 * @property TournamentsHasPlayers[] $tournamentsHasPlayers
 * @property Tournaments[] $tournamentsIdtournaments
 */
class Players extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'players';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idplayers', 'user_id'], 'required'],
            [['idplayers', 'running_nr', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idplayers' => Yii::t('app', 'Idplayers'),
            'name' => Yii::t('app', 'Name'),
            'running_nr' => Yii::t('app', 'Running Nr'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches()
    {
        return $this->hasMany(Matches::className(), ['players_idplayerA' => 'idplayers']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatches0()
    {
        return $this->hasMany(Matches::className(), ['players_idplayerB' => 'idplayers']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayersHasTeams()
    {
        return $this->hasMany(PlayersHasTeams::className(), ['players_idplayers' => 'idplayers']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamsIdteams()
    {
        return $this->hasMany(Teams::className(), ['idteams' => 'teams_idteams'])->viaTable('players_has_teams', ['players_idplayers' => 'idplayers']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSignups()
    {
        return $this->hasMany(Signups::className(), ['players_idplayers' => 'idplayers']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentsHasPlayers()
    {
        return $this->hasMany(TournamentsHasPlayers::className(), ['players_idplayers' => 'idplayers']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentsIdtournaments()
    {
        return $this->hasMany(Tournaments::className(), ['idtournaments' => 'tournaments_idtournaments', 'user_id' => 'tournaments_user_id'])->viaTable('tournaments_has_players', ['players_idplayers' => 'idplayers']);
    }
}
