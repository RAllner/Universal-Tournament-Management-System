<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "signups".
 *
 * @property integer $idsignups
 * @property integer $tournaments_idtournaments
 * @property integer $players_idplayers
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Players $playersIdplayers
 * @property Tournaments $tournamentsIdtournaments
 */
class Signups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'signups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idsignups', 'tournaments_idtournaments', 'players_idplayers'], 'required'],
            [['idsignups', 'tournaments_idtournaments', 'players_idplayers', 'created_at', 'updated_at'], 'integer'],
            [['players_idplayers'], 'exist', 'skipOnError' => true, 'targetClass' => Players::className(), 'targetAttribute' => ['players_idplayers' => 'idplayers']],
            [['tournaments_idtournaments'], 'exist', 'skipOnError' => true, 'targetClass' => Tournaments::className(), 'targetAttribute' => ['tournaments_idtournaments' => 'idtournaments']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idsignups' => Yii::t('app', 'Idsignups'),
            'tournaments_idtournaments' => Yii::t('app', 'Tournaments Idtournaments'),
            'players_idplayers' => Yii::t('app', 'Players Idplayers'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
        return $this->hasOne(Tournaments::className(), ['idtournaments' => 'tournaments_idtournaments']);
    }
}
