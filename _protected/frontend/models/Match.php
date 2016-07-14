<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%match}}".
 *
 * @property integer $id
 * @property integer $participant_id_A
 * @property integer $participant_id_B
 * @property string $score
 * @property integer $winner_id
 * @property integer $loser_id
 * @property integer $running
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $begin_at
 * @property string $finished_at
 * @property resource $metablob
 *
 * @property Participant $participantIdA
 * @property Participant $participantIdB
 */
class Match extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%match}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'participant_id_A', 'participant_id_B'], 'required'],
            [['id', 'participant_id_A', 'participant_id_B', 'winner_id', 'loser_id', 'running', 'updated_at', 'created_at'], 'integer'],
            [['begin_at', 'finished_at'], 'safe'],
            [['metablob'], 'string'],
            [['score'], 'string', 'max' => 255],
            [['participant_id_A'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id_A' => 'id']],
            [['participant_id_B'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id_B' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'participant_id_A' => Yii::t('app', 'Participant Id  A'),
            'participant_id_B' => Yii::t('app', 'Participant Id  B'),
            'score' => Yii::t('app', 'Score'),
            'winner_id' => Yii::t('app', 'Winner ID'),
            'loser_id' => Yii::t('app', 'Loser ID'),
            'running' => Yii::t('app', 'Running'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'begin_at' => Yii::t('app', 'Begin At'),
            'finished_at' => Yii::t('app', 'Finished At'),
            'metablob' => Yii::t('app', 'Metablob'),
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
    public function getParticipantIdA()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id_A']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantIdB()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id_B']);
    }
}
