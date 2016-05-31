<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "players_has_teams".
 *
 * @property integer $players_idplayers
 * @property integer $teams_idteams
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $rights
 *
 * @property Players $playersIdplayers
 * @property Teams $teamsIdteams
 */
class PlayersHasTeams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'players_has_teams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['players_idplayers', 'teams_idteams'], 'required'],
            [['players_idplayers', 'teams_idteams', 'updated_at', 'created_at'], 'integer'],
            [['rights'], 'string', 'max' => 45],
            [['players_idplayers'], 'exist', 'skipOnError' => true, 'targetClass' => Players::className(), 'targetAttribute' => ['players_idplayers' => 'idplayers']],
            [['teams_idteams'], 'exist', 'skipOnError' => true, 'targetClass' => Teams::className(), 'targetAttribute' => ['teams_idteams' => 'idteams']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'players_idplayers' => Yii::t('app', 'Players Idplayers'),
            'teams_idteams' => Yii::t('app', 'Teams Idteams'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'rights' => Yii::t('app', 'Rights'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayersIdplayers()
    {
        return $this->hasOne(Players::className(), ['idplayers' => 'players_idplayers']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamsIdteams()
    {
        return $this->hasOne(Teams::className(), ['idteams' => 'teams_idteams']);
    }
}
