<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrganisationHasUser */
/* @var $form ActiveForm */
$this->title = Yii::t('app', 'Add Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organisations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="organisation-add">
    <h1>Add Member</h1>
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
