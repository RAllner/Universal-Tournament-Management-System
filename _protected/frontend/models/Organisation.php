<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "organisation".
 *
 * @property integer $idorganisation
 * @property string $name
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property OrganisationHasUser[] $organisationHasUsers
 * @property User[] $users
 * @property Tournaments[] $tournaments
 */
class Organisation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organisation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idorganisation'], 'required'],
            [['idorganisation', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idorganisation' => Yii::t('app', 'Idorganisation'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganisationHasUsers()
    {
        return $this->hasMany(OrganisationHasUser::className(), ['organisation_idorganisation' => 'idorganisation']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('organisation_has_user', ['organisation_idorganisation' => 'idorganisation']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTournaments()
    {
        return $this->hasMany(Tournaments::className(), ['organisation_idorganisation' => 'idorganisation']);
    }
}
