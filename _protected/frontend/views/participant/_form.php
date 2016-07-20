<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="participant-form">

    <?php $form = ActiveForm::begin(); ?>

        <?php if ($model->tournament->is_team_tournament == 0): ?>
            <?= $form->field($model, 'player_id')->dropDownList(ArrayHelper::map($model->players, 'id', 'name')) ?>
        <?php endif ?>
        <?php if ($model->tournament->is_team_tournament == 1 && !is_null($model->teams)): ?>
            <?= $form->field($model, 'team_id')->dropDownList(ArrayHelper::map($model->teams, 'id', 'name')) ?>
        <?php endif ?>
        <?php if ($model->tournament->is_team_tournament == 1 && is_null($model->teams)): ?>
            <?= Yii::t('app', 'You have no teams to register')?>
        <?php endif ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
