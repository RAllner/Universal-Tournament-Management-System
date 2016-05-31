<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TournamentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tournaments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idtournaments') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'begin') ?>

    <?= $form->field($model, 'end') ?>

    <?= $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'sports_idsports') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'max_participants') ?>

    <?php // echo $form->field($model, 'third_place') ?>

    <?php // echo $form->field($model, 'format') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'has_sets') ?>

    <?php // echo $form->field($model, 'tournamentscol') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'organisation_idorganisation') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
