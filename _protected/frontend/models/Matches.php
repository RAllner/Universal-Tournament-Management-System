<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "matches".
 *
 * @property integer $idmatches
 * @property integer $pointsA
 * @property integer $pointsB
 * @property integer $tournaments_idtournaments
 * @property integer $players_idplayerA
 * @property integer $players_idplayerB
 *
 * @property Players $playersIdplayerA
 * @property Players $playersIdplayerB
 * @property Tournaments $tournamentsIdtournaments
 * @property Sets[] $sets
 */
class Matches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'matches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idmatches', 'tournaments_idtournaments', 'players_idplayerA', 'players_idplayerB'], 'required'],
            [['idmatches', 'pointsA', 'pointsB', 'tournaments_idtournaments', 'players_idplayerA', 'players_idplayerB'], 'integer'],
            [['players_idplayerA'], 'exist', 'skipOnError' => true, 'targetClass' => Players::className(), 'targetAttribute' => ['players_idplayerA' => 'idplayers']],
            [['players_idplayerB'], 'exist', 'skipOnError' => true, 'targetClass' => Players::className(), 'targetAttribute' => ['players_idplayerB' => 'idplayers']],
            [['tournaments_idtournaments'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournaments_idtournaments' => 'idtournaments']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idmatches' => Yii::t('app', 'Idmatches'),
            'pointsA' => Yii::t('app', 'Points A'),
            'pointsB' => Yii::t('app', 'Points B'),
            'tournaments_idtournaments' => Yii::t('app', 'Tournaments Idtournaments'),
            'players_idplayerA' => Yii::t('app', 'Players Idplayer A'),
            'players_idplayerB' => Yii::t('app', 'Players Idplayer B'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayersIdplayerA()
    {
        return $this->hasOne(Players::className(), ['idplayers' => 'players_idplayerA']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlayersIdplayerB()
    {
        return $this->hasOne(Players::className(), ['idplayers' => 'players_idplayerB']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournamentsIdtournaments()
    {
        return $this->hasOne(Tournaments::className(), ['idtournaments' => 'tournaments_idtournaments']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSets()
    {
        return $this->hasMany(Sets::className(), ['matches_idmatches' => 'idmatches', 'matches_tournaments_idtournaments' => 'tournaments_idtournaments']);
    }
}
