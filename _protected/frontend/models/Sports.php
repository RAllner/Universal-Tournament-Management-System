<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sports".
 *
 * @property integer $id
 * @property string $name
 * @property string $rules
 */
class Sports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rules'], 'required'],
            [['name', 'rules'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'rules' => Yii::t('app', 'Rules'),
        ];
    }
}
