<?php

use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */
/* @var $form yii\widgets\ActiveForm */
/* @var $tournament frontend\models\Tournament */

?>

<div class="participant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (Yii::$app->user->can('member')): ?>

        <div class="well">

            <?php if ($model->tournament->is_team_tournament == 0 && !empty($model->players)): ?>
                <?= $form->field($model, 'player_id')->dropDownList(ArrayHelper::map($model->players, 'id', 'name')) ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Signup') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php endif ?>
            <?php if ($model->tournament->is_team_tournament == 0 && empty($model->players)): ?>
                <?= Yii::t('app', 'You are already registered or you have no player profile to do so.') ?>
                <?php if (Yii::$app->user->can('createPlayer')): ?>
                    <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create player profile'), ['player/create'], ['class' => 'btn btn-success']) ?>
                <?php endif ?>
            <?php endif ?>
            <?php if ($model->tournament->is_team_tournament == 1 && !is_null($model->teams)): ?>
                <?= $form->field($model, 'team_id')->dropDownList(ArrayHelper::map($model->teams, 'id', 'name')) ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Signup') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            <?php endif ?>
            <?php if ($model->tournament->is_team_tournament == 1 && is_null($model->teams)): ?>
                <?= Yii::t('app', 'You have no teams to register. You can create or request to join a team.') ?>
                </br>
                <?php if (Yii::$app->user->can('createPlayer')): ?>
                    <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Signup'), ['team/create'], ['class' => 'btn btn-success']) ?>
                <?php endif ?>
            <?php endif ?>

        </div>

    <?php endif ?>

    <?php ActiveForm::end(); ?>


</div>
