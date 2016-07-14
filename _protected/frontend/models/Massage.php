<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%massage}}".
 *
 * @property integer $id
 * @property integer $from
 * @property integer $to
 * @property string $massage
 * @property integer $marked
 * @property integer $deleted
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $conversation_id
 *
 * @property Conversation $conversation
 */
class Massage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%massage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to', 'massage', 'deleted', 'conversation_id'], 'required'],
            [['from', 'to', 'marked', 'deleted', 'created_at', 'updated_at', 'conversation_id'], 'integer'],
            [['massage'], 'string'],
            [['conversation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conversation::className(), 'targetAttribute' => ['conversation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'massage' => Yii::t('app', 'Massage'),
            'marked' => Yii::t('app', 'Marked'),
            'deleted' => Yii::t('app', 'Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'conversation_id' => Yii::t('app', 'Conversation ID'),
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
    public function getConversation()
    {
        return $this->hasOne(Conversation::className(), ['id' => 'conversation_id']);
    }
}
