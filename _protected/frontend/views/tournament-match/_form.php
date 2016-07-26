<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentMatch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tournament-match-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'tournament_id')->textInput() ?>

    <?= $form->field($model, 'stage')->textInput() ?>

    <?= $form->field($model, 'matchID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'groupID')->textInput() ?>

    <?= $form->field($model, 'round')->textInput() ?>

    <?= $form->field($model, 'participant_id_A')->textInput() ?>

    <?= $form->field($model, 'participant_score_A')->textInput() ?>

    <?= $form->field($model, 'participant_id_B')->textInput() ?>

    <?= $form->field($model, 'participant_score_B')->textInput() ?>

    <?= $form->field($model, 'winner_id')->textInput() ?>

    <?= $form->field($model, 'loser_id')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'begin_at')->textInput() ?>

    <?= $form->field($model, 'finished_at')->textInput() ?>

    <?= $form->field($model, 'metablob')->textInput() ?>

    <?= $form->field($model, 'state')->textInput() ?>

    <?= $form->field($model, 'follow_winner_and_loser_match_ids')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qualification_match_ids')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'losers_round')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
