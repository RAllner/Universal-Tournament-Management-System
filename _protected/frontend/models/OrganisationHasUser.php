<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * This is the model class for table "organisation_has_user".
 *
 * @property integer $organisation_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $admin
 *
 * @property Organisation $organisation
 * @property User $user
 */
class OrganisationHasUser extends ActiveRecord
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
            [['organisation_id', 'user_id'], 'required'],
            [['organisation_id', 'user_id', 'admin'], 'integer'],
            [['organisation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organisation::className(), 'targetAttribute' => ['organisation_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'organisation_id' => Yii::t('app', 'Organisation ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'admin' => Yii::t('app', 'Admin'),
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
    public function getOrganisation()
    {
        return $this->hasOne(Organisation::className(), ['id' => 'organisation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Returns the admin status as int.
     *
     * @return int
     *
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
