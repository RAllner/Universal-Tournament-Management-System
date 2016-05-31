<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sets".
 *
 * @property integer $idsets
 * @property integer $matches_idmatches
 * @property integer $matches_tournaments_idtournaments
 * @property integer $set_wins_A
 * @property integer $set_wins_B
 *
 * @property Matches $matchesIdmatches
 */
class Sets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idsets', 'matches_idmatches', 'matches_tournaments_idtournaments'], 'required'],
            [['idsets', 'matches_idmatches', 'matches_tournaments_idtournaments', 'set_wins_A', 'set_wins_B'], 'integer'],
            [['matches_idmatches', 'matches_tournaments_idtournaments'], 'exist', 'skipOnError' => true, 'targetClass' => Matches::className(), 'targetAttribute' => ['matches_idmatches' => 'idmatches', 'matches_tournaments_idtournaments' => 'tournaments_idtournaments']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idsets' => Yii::t('app', 'Idsets'),
            'matches_idmatches' => Yii::t('app', 'Matches Idmatches'),
            'matches_tournaments_idtournaments' => Yii::t('app', 'Matches Tournaments Idtournaments'),
            'set_wins_A' => Yii::t('app', 'Set Wins  A'),
            'set_wins_B' => Yii::t('app', 'Set Wins  B'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatchesIdmatches()
    {
        return $this->hasOne(Matches::className(), ['idmatches' => 'matches_idmatches', 'tournaments_idtournaments' => 'matches_tournaments_idtournaments']);
    }
}
