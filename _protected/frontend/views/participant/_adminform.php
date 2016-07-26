<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */
/* @var $form yii\widgets\ActiveForm */
/* @var $source array */

?>

<div class="participant-adminForm">

    <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'name')->textInput()->hint(Yii::t('app', 'Enter a participant name.')) ?>
                <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

</div>
