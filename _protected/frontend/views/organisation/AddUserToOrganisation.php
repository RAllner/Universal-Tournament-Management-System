<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrganisationHasUser */
/* @var $form ActiveForm */
?>
<div class="AddUserToOrganisation">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'organisation_id') ?>
        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'admin') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- AddUserToOrganisation -->
