<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 15.09.2016
 * Time: 15:17
 */
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm  */
/* @var $model frontend\models\ParticipantExternalSignupForm */


?>
<div class="participant-signup">

    <p><?= Yii::t('app', 'Please fill out the following fields to signup:') ?></p>

    <?php $form = ActiveForm::begin(['id' => 'participant-signup']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Enter your name here. E.g. Kanzler#1234')) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->hint(Yii::t('app', 'Enter your mail address here, if you want to receive a confirmation and reminder mail.')) ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>