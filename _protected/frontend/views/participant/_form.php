<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="participant-form">

    <?php if(Yii::$app->user->can('member')): ?>
    <?php $form = ActiveForm::begin(); ?>


        <?php if ($model->tournament->is_team_tournament == 0 && !is_null($model->players)): ?>
            <?= $form->field($model, 'player_id')->dropDownList(ArrayHelper::map($model->players, 'id', 'name')) ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Register') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php endif ?>
        <?php if ($model->tournament->is_team_tournament == 0 && is_null($model->players)): ?>
            <?= Yii::t('app', 'You have no players to register. You can create one.')?>
            <?php if (Yii::$app->user->can('createPlayer')): ?>
                <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Player'), ['player/create'], ['class' => 'btn btn-success']) ?>
            <?php endif ?>
        <?php endif ?>
        <?php if ($model->tournament->is_team_tournament == 1 && !is_null($model->teams)): ?>
            <?= $form->field($model, 'team_id')->dropDownList(ArrayHelper::map($model->teams, 'id', 'name')) ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Register') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php endif ?>
        <?php if ($model->tournament->is_team_tournament == 1 && is_null($model->teams)): ?>
            <?= Yii::t('app', 'You have no teams to register. You can create or request to join a team.')?>
            </br>
            <?php if (Yii::$app->user->can('createPlayer')): ?>
                <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Register Team'), ['team/create'], ['class' => 'btn btn-success']) ?>
            <?php endif ?>
        <?php endif ?>


    <?php ActiveForm::end(); ?>
    <?php endif ?>
    
</div>
