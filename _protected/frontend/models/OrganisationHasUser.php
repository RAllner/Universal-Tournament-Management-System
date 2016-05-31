<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organisation_has_user".
 *
 * @property integer $organisation_idorganisation
 * @property integer $user_id
 * @property string $rights
 *
 * @property Organisation $organisationIdorganisation
 * @property User $user
 */
class OrganisationHasUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organisation_has_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organisation_idorganisation', 'user_id'], 'required'],
            [['organisation_idorganisation', 'user_id'], 'integer'],
            [['rights'], 'string', 'max' => 45],
            [['organisation_idorganisation'], 'exist', 'skipOnError' => true, 'targetClass' => Organisation::className(), 'targetAttribute' => ['organisation_idorganisation' => 'idorganisation']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organisation_idorganisation' => Yii::t('app', 'Organisation Idorganisation'),
            'user_id' => Yii::t('app', 'User ID'),
            'rights' => Yii::t('app', 'Rights'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationIdorganisation()
    {
        return $this->hasOne(Organisation::className(), ['idorganisation' => 'organisation_idorganisation']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
