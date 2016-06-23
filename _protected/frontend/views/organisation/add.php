<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrganisationHasUser */
/* @var $form ActiveForm */
?>
<div class="organisation-add">
    <div class="container">
    <div class="row">
        <div class="well col-lg-8">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username')) ?>
            <?= $form->field($model, 'admin')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div><!-- AddUserToOrganisation -->
