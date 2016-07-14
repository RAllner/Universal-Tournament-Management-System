<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id
 * @property string $massage
 * @property integer $marked
 * @property integer $deleted
 * @property integer $user_id
 *
 * @property User $user
 */
class Notification extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['massage', 'deleted', 'user_id'], 'required'],
            [['marked', 'deleted', 'user_id'], 'integer'],
            [['massage'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'massage' => Yii::t('app', 'Massage'),
            'marked' => Yii::t('app', 'Marked'),
            'deleted' => Yii::t('app', 'Deleted'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
