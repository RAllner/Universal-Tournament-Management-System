<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tempusers".
 *
 * @property integer $idtempusers
 * @property string $_loginID
 * @property string $_pw
 * @property string $_name
 * @property string $valid_from
 * @property string $valid_to
 * @property integer $tournament
 * @property integer $user_id
 *
 * @property User $user
 */
class Tempusers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tempusers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtempusers', 'user_id'], 'required'],
            [['idtempusers', 'tournament', 'user_id'], 'integer'],
            [['valid_from', 'valid_to'], 'safe'],
            [['_loginID', '_pw', '_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtempusers' => Yii::t('app', 'Idtempusers'),
            '_loginID' => Yii::t('app', 'Login ID'),
            '_pw' => Yii::t('app', 'Pw'),
            '_name' => Yii::t('app', 'Name'),
            'valid_from' => Yii::t('app', 'Valid From'),
            'valid_to' => Yii::t('app', 'Valid To'),
            'tournament' => Yii::t('app', 'Tournament'),
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
