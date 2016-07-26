<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%bulk}}".
 *
 * @property integer $id
 * @property resource $bulk
 * @property integer $tournament_id
 *
 * @property Tournament $tournament
 */
class Bulk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bulk}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bulk'], 'string'],
            [['tournament_id'], 'required'],
            [['tournament_id'], 'integer'],
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
            'bulk' => Yii::t('app', 'Bulk'),
            'tournament_id' => Yii::t('app', 'Tournament ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournament()
    {
        return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
    }
}
