<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Model representing  ParticipantExternalSignup Form.
 */
class ParticipantExternalSignupForm extends Model
{
    public $name;
    public $email;
    public $verifyCode;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['verifyCode', 'captcha'],
            ['verifyCode', 'required' ],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Signs up the user.
     * If scenario is set to "rna" (registration needs activation), this means
     * that user need to activate his account using email confirmation method.
     *
     * @return User|null The saved model or null if saving fails.
     */
    public function signup($participant)
    {
        /** @var Participant $participant */
        $participant->name = $this->name;
        $participant->email = $this->email;
        $participant->signup = Participant::SIGNUP_STATUS_EXTERNAL;
        return $participant;
    }

}
