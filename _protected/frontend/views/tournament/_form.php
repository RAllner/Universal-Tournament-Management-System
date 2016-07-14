<?php

use frontend\models\Game;
use frontend\models\Location;
use kartik\widgets\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tournament-form">


    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'hosted_by')->dropDownList($model->hostedByList) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'notifications')->checkbox() ?>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'begin')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => Yii::t('app', 'Enter event start time ... ')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii'

                ]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'end')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => Yii::t('app', 'Enter event end time ... (if you want)')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii'
                ]
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="input-group">
                <?= $form->field($model, 'location')->dropDownList(ArrayHelper::map(Location::find()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Please choose ...')]) ?>
                <?= Html::a('<i class="material-icons">add</i>', ['location/create'], ['class' => 'input-group-btn btn']) ?>
            </div>
        </div>
        <div class="col-md-6">

            <div class="input-group">
                <?= $form->field($model, 'game_id')->dropDownList(ArrayHelper::map(Game::find()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Please choose ...')]) ?>
                <?= Html::a('<i class="material-icons">add</i>', ['game/create'], ['class' => 'input-group-btn btn']) ?>
            </div>

        </div>
    </div>

    <hr>

    <?= $form->field($model, 'description')->widget(CKEditor::className(),
        ['editorOptions' => ['preset' => 'standard', 'inline' => false]]); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>

    <?= $form->field($model, 'max_participants')->textInput(['type' => 'number','min'=>2, 'value'=>50]) ?>

    <?= $form->field($model, 'has_sets')->checkbox() ?>

    <?= $form->field($model, 'stage_type')->radioList(array('0' => Yii::t('app', 'Single Stage Tournament'), '1' => Yii::t('app', 'Two Stage Tournament'))) ?>

    <hr>

    <?= $form->field($model, 'gs_format')->dropDownList($model->groupStageFormatList) ?>

    <?= $form->field($model, 'participants_compete')->textInput(['type' => 'number','min'=>1, 'value'=>4]) ?>

    <?= $form->field($model, 'participants_advance')->textInput(['type' => 'number','min'=>1, 'value'=>2]) ?>

    <?= $form->field($model, 'gs_rr_ranked_by')->dropDownList($model->rankedByList) ?>

    <?= $form->field($model, 'gs_rr_ppmw')->textInput() ?>

    <?= $form->field($model, 'gs_rr_ppmt')->textInput() ?>

    <?= $form->field($model, 'gs_rr_ppgw')->textInput() ?>

    <?= $form->field($model, 'gs_rr_ppgt')->textInput() ?>

    <?= $form->field($model, 'gs_tie_break1')->textInput() ?>

    <?= $form->field($model, 'gs_tie_break2')->textInput() ?>

    <hr>

    <?= $form->field($model, 'first_stage')->textInput() ?>

    <?= $form->field($model, 'fs_format')->dropDownList($model->formatList) ?>

    <?= $form->field($model, 'fs_third_place')->checkbox() ?>

    <?= $form->field($model, 'fs_de_grand_finals')->checkbox() ?>

    <?= $form->field($model, 'fs_rr_ranked_by')->dropDownList($model->rankedByList) ?>

    <?= $form->field($model, 'fs_rr_ppmw')->textInput() ?>

    <?= $form->field($model, 'fs_rr_ppmt')->textInput() ?>

    <?= $form->field($model, 'fs_rr_ppgw')->textInput() ?>

    <?= $form->field($model, 'fs_rr_ppgt')->textInput() ?>

    <?= $form->field($model, 'fs_s_ppb')->textInput() ?>





    <?= $form->field($model, 'quick_advance')->checkbox() ?>

    <?= $form->field($model, 'gs_tie_break3')->textInput() ?>

    <?= $form->field($model, 'gs_tie_break1_copy1')->textInput() ?>

    <?= $form->field($model, 'gs_tie_break2_copy1')->textInput() ?>

    <?= $form->field($model, 'gs_tie_break3_copy1')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
