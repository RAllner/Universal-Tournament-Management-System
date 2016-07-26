<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentMatchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tournament-match-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tournament_id') ?>

    <?= $form->field($model, 'stage') ?>

    <?= $form->field($model, 'matchID') ?>

    <?= $form->field($model, 'groupID') ?>

    <?php // echo $form->field($model, 'round') ?>

    <?php // echo $form->field($model, 'participant_id_A') ?>

    <?php // echo $form->field($model, 'participant_score_A') ?>

    <?php // echo $form->field($model, 'participant_id_B') ?>

    <?php // echo $form->field($model, 'participant_score_B') ?>

    <?php // echo $form->field($model, 'winner_id') ?>

    <?php // echo $form->field($model, 'loser_id') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'begin_at') ?>

    <?php // echo $form->field($model, 'finished_at') ?>

    <?php // echo $form->field($model, 'metablob') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'follow_winner_and_loser_match_ids') ?>

    <?php // echo $form->field($model, 'qualification_match_ids') ?>

    <?php // echo $form->field($model, 'losers_round') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
