<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tournaments_has_players".
 *
 * @property integer $tournaments_idtournaments
 * @property integer $tournaments_user_id
 * @property integer $players_idplayers
 *
 * @property Players $playersIdplayers
 * @property Tournaments $tournamentsIdtournaments
 */
class TournamentsHasPlayers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tournaments_has_players';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tournaments_idtournaments', 'tournaments_user_id', 'players_idplayers'], 'required'],
            [['tournaments_idtournaments', 'tournaments_user_id', 'players_idplayers'], 'integer'],
            [['players_idplayers'], 'exist', 'skipOnError' => true, 'targetClass' => Players::className(), 'targetAttribute' => ['players_idplayers' => 'idplayers']],
            [['tournaments_idtournaments', 'tournaments_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournaments_idtournaments' => 'idtournaments', 'tournaments_user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tournaments_idtournaments' => Yii::t('app', 'Tournaments Idtournaments'),
            'tournaments_user_id' => Yii::t('app', 'Tournaments User ID'),
            'players_idplayers' => Yii::t('app', 'Players Idplayers'),
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
    public function getTournamentsIdtournaments()
    {
        return $this->hasOne(Tournaments::className(), ['idtournaments' => 'tournaments_idtournaments', 'user_id' => 'tournaments_user_id']);
    }
}
