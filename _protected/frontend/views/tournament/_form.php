<?php

use frontend\models\Game;
use frontend\models\Location;
use frontend\models\Tournament;
use kartik\widgets\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tournament */
/* @var $form yii\widgets\ActiveForm */

$script = <<< JS
$(document).ready(function(){
    $('#final-stage-header').hide();
    $('.group-stage').hide();
    $('.gs-custom-points').hide();
    $('.form-group.field-tournament-gs_rr_ranked_by').hide();       
    $('.form-group.field-tournament-fs_third_place').show();
    $('.form-group.field-tournament-fs_rr_ranked_by').hide();
    $('.form-group.field-tournament-fs_de_grand_finals').hide();
    $('.field-tournament-fs_s_ppb').hide();
    $('.fs-custom-points').hide();
    if($('#tournament-stage_type').is('[disabled]')){
         $('#tournament-stage_type input').prop('disabled', true);
    }
    if($('#tournament-fs_de_grand_finals').is('[disabled]')){
             $('#tournament-fs_de_grand_finals input').prop('disabled', true);
    }
    $('#tournament-stage_type > label > input[type="radio"]').click((function(){
        var stage = $('#tournament-stage_type > label > input[type="radio"]:checked').val();
        if (stage == 0){
            $('.group-stage').hide();
            $('#final-stage-header').hide();
            $('.field-tournament-fs_s_ppb').hide();
        } else {
            $('.group-stage').show();
            $('#final-stage-header').show();
            $('.field-tournament-fs_s_ppb').show();
        }
    }));
            var stage = $('#tournament-stage_type > label > input[type="radio"]:checked').val();
        if (stage == 0){
            $('.group-stage').hide();
            $('#final-stage-header').hide();
            $('.field-tournament-fs_s_ppb').hide();
        } else {
            $('.group-stage').show();
            $('#final-stage-header').show();
            $('.field-tournament-fs_s_ppb').show();
        }
    $('#tournament-gs_rr_ranked_by').change(function() {
       if($('#tournament-gs_rr_ranked_by').val() == 6) {
            $('.gs-custom-points').show();
       } else {
            $('.gs-custom-points').hide();
       }
    });
           if($('#tournament-gs_rr_ranked_by').val() == 6) {
            $('.gs-custom-points').show();
       } else {
            $('.gs-custom-points').hide();
       }
    $('#tournament-fs_rr_ranked_by').change(function() {
       if($('#tournament-fs_rr_ranked_by').val() == 6) {
            $('.fs-custom-points').show();
       } else {
            $('.fs-custom-points').hide();
       }
    })
           if($('#tournament-fs_rr_ranked_by').val() == 6) {
            $('.fs-custom-points').show();
       } else {
            $('.fs-custom-points').hide();
       }
    $('#tournament-gs_format').change(function() {
        if($('#tournament-gs_format').val() == 3){
            $('.form-group.field-tournament-gs_rr_ranked_by').show();
             if($('#tournament-gs_rr_ranked_by').val() == 6){ 
                $('.gs-custom-points').show();
            } else {
                $('.gs-custom-points').hide();
            }
        } else {
            $('.form-group.field-tournament-gs_rr_ranked_by').hide();
            $('.gs-custom-points').hide();
        }
    })
            if($('#tournament-gs_format').val() == 3){
            $('.form-group.field-tournament-gs_rr_ranked_by').show();
             if($('#tournament-gs_rr_ranked_by').val() == 6){ 
                $('.gs-custom-points').show();
            } else {
                $('.gs-custom-points').hide();
            }
        } else {
            $('.form-group.field-tournament-gs_rr_ranked_by').hide();
            $('.gs-custom-points').hide();
        }
            if($('#tournament-fs_format').val() == 1){
            $('.form-group.field-tournament-fs_third_place').show();
            $('.form-group.field-tournament-fs_rr_ranked_by').hide();
            $('.form-group.field-tournament-fs_de_grand_finals').hide();
            $('.fs-custom-points').hide();
        } else if ($('#tournament-fs_format').val() == 2){
            $('.form-group.field-tournament-fs_third_place').hide();
            $('.form-group.field-tournament-fs_rr_ranked_by').hide();
            $('.form-group.field-tournament-fs_de_grand_finals').show();
            $('.fs-custom-points').hide();
        } else if ($('#tournament-fs_format').val() == 3){
            $('.form-group.field-tournament-fs_third_place').hide();
            $('.form-group.field-tournament-fs_rr_ranked_by').show();
            $('.form-group.field-tournament-fs_de_grand_finals').hide();
            if($('#tournament-fs_rr_ranked_by').val() == 6){ 
                $('.fs-custom-points').show();
            } else {
                $('.fs-custom-points').hide();
            }
        } else {
            $('.form-group.field-tournament-fs_third_place').hide();
            $('.form-group.field-tournament-fs_rr_ranked_by').hide();
            $('.form-group.field-tournament-fs_de_grand_finals').hide();
            $('.fs-custom-points').show();
        }
        $('#tournament-fs_format').change(function() {
        if($('#tournament-fs_format').val() == 1){
            $('.form-group.field-tournament-fs_third_place').show();
            $('.form-group.field-tournament-fs_rr_ranked_by').hide();
            $('.form-group.field-tournament-fs_de_grand_finals').hide();
            $('.fs-custom-points').hide();
        } else if ($('#tournament-fs_format').val() == 2){
            $('.form-group.field-tournament-fs_third_place').hide();
            $('.form-group.field-tournament-fs_rr_ranked_by').hide();
            $('.form-group.field-tournament-fs_de_grand_finals').show();
            $('.fs-custom-points').hide();
        } else if ($('#tournament-fs_format').val() == 3){
            $('.form-group.field-tournament-fs_third_place').hide();
            $('.form-group.field-tournament-fs_rr_ranked_by').show();
            $('.form-group.field-tournament-fs_de_grand_finals').hide();
            if($('#tournament-fs_rr_ranked_by').val() == 6){ 
                $('.fs-custom-points').show();
            } else {
                $('.fs-custom-points').hide();
            }
        } else {
            $('.form-group.field-tournament-fs_third_place').hide();
            $('.form-group.field-tournament-fs_rr_ranked_by').hide();
            $('.form-group.field-tournament-fs_de_grand_finals').hide();
            $('.fs-custom-points').show();
        }
    })
    
    
    
}); 
JS;
$this->registerJs($script, View::POS_END);

$readOnly = ($model->status >= Tournament::STATUS_RUNNING) ? ['readonly' => true, 'disabled' => true] : ['readonly' => false];
$readOnlyBoolean = ($model->status >= Tournament::STATUS_RUNNING) ? true : false;

?>

<div class="tournament-form">


    <h2><?= Yii::t('app', 'General') ?></h2>
    <?php $form = ActiveForm::begin(); ?>

    <div class="well">
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6">
                <?= $form->field($model, 'description')->widget(CKEditor::className(),
                    ['editorOptions' => ['preset' => 'standard', 'inline' => false]]); ?>


            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'hosted_by')->dropDownList(ArrayHelper::map($model->hostedByList, "id", "name", "class"), $readOnly) ?>

                <?= $form->field($model, 'begin')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => Yii::t('app', 'Enter event start time ... ')],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii'

                    ]
                ]); ?>

                <?= $form->field($model, 'end')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => Yii::t('app', 'Enter event end time ... (if you want)')],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:ii'
                    ]
                ]); ?>

                <div class="input-group">
                    <?= $form->field($model, 'location')->dropDownList(ArrayHelper::map(Location::find()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Please choose ...')]) ?>
                    <?= Html::a('<i class="material-icons">add</i>', ['location/create'], ['class' => 'input-group-btn btn']) ?>
                </div>

                <div class="input-group">
                    <?= $form->field($model, 'game_id')->dropDownList(ArrayHelper::map(Game::find()->all(), 'id', 'name'), ['prompt' => Yii::t('app', 'Please choose ...')]) ?>
                    <?= Html::a('<i class="material-icons">add</i>', ['game/create'], ['class' => 'input-group-btn btn']) ?>
                </div>


            </div>
        </div>
    </div>

    <h2><?= Yii::t('app', 'Tournament format') ?></h2>

    <div class="well">
        <?= $form->field($model, 'is_team_tournament')->checkbox($readOnly) ?>

        <?= $form->field($model, 'stage_type')->radioList([0 => Yii::t('app', 'Single Stage Tournament'), 1 => Yii::t('app', 'Two Stage Tournament')], $readOnly) ?>


        <div class="group-stage">
            <div class="well">
                <h3><?= Yii::t('app', 'Group Stage') ?></h3>
                <div class="row">
                    <div class="col-md-6">

                        <?= $form->field($model, 'gs_format')->dropDownList($model->groupStageFormatList, $readOnly) ?>

                        <?= $form->field($model, 'participants_compete')->textInput(['type' => 'number', 'min' => 1, 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                        <?= $form->field($model, 'participants_advance')->textInput(['type' => 'number', 'min' => 1, 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                        <?= $form->field($model, 'gs_rr_ranked_by')->dropDownList($model->rankedByList, $readOnly) ?>
                    </div>

                    <div class="col-md-6 gs-custom-points">

                        <?= $form->field($model, 'gs_rr_ppmw')->textInput(['value' => '1.0', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                        <?= $form->field($model, 'gs_rr_ppmt')->textInput(['value' => '0.5', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                        <?= $form->field($model, 'gs_rr_ppgw')->textInput(['value' => '0.0', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                        <?= $form->field($model, 'gs_rr_ppgt')->textInput(['value' => '0.0', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                    </div>
                </div>

            </div>
        </div>

    <div class="final-stage">
        <div class="well">
            <h3 id="final-stage-header"><?= Yii::t('app', 'Final Stage') ?></h3>
            <div class="row">
                <div class="col-md-6">

                    <?= $form->field($model, 'fs_format')->dropDownList($model->formatList, $readOnly) ?>

                    <?= $form->field($model, 'fs_third_place')->checkbox($readOnly) ?>

                    <?= $form->field($model, 'fs_de_grand_finals')->radioList(['0' => Yii::t('app', '1-2 matches'), '1' => Yii::t('app', '1 match'), '2' => Yii::t('app', 'None')], $readOnly) ?>

                    <?= $form->field($model, 'fs_rr_ranked_by')->dropDownList($model->rankedByList, $readOnly) ?>
                </div>
                <div class="col-md-6 fs-custom-points">
                    <?= $form->field($model, 'fs_rr_ppmw')->textInput(['value' => '1.0', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                    <?= $form->field($model, 'fs_rr_ppmt')->textInput(['value' => '0.5', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                    <?= $form->field($model, 'fs_rr_ppgw')->textInput(['value' => '0.0', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                    <?= $form->field($model, 'fs_rr_ppgt')->textInput(['value' => '0.0', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>

                    <?= $form->field($model, 'fs_s_ppb')->textInput(['value' => '1.0', 'readonly' => $readOnlyBoolean, 'disabled' => $readOnlyBoolean]) ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <h3><?= Yii::t('app', 'Advanced Settings') ?></h3>
    <div class="well">
        <?= $form->field($model, 'quick_advance')->checkbox($readOnly) ?>

        <?= $form->field($model, 'has_sets')->checkbox($readOnly) ?>



        <?= $form->field($model, 'notifications')->checkbox() ?>

        <?= $form->field($model, 'url')->hiddenInput()->label(false) ?>

        <?php if ($model->isNewRecord): ?>
            <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>
        <?php endif ?>

        <?= $form->field($model, 'max_participants')->textInput(['type' => 'number', 'min' => 2, 'value' => 50]) ?>


        <?= $form->field($model, 'organisation_id')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'participants_count')->hiddenInput()->label(false) ?>



        <?= $form->field($model, 'gs_tie_break1')->dropDownList($model->matchTiesByList, ['value' => 6])->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'gs_tie_break2')->dropDownList($model->matchTiesByList, ['value' => 2])->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'gs_tie_break3')->dropDownList($model->matchTiesByList, ['value' => 4])->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'gs_tie_break1_copy1')->dropDownList($model->matchTiesByList, ['value' => 6])->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'gs_tie_break2_copy1')->dropDownList($model->matchTiesByList, ['value' => 2])->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'gs_tie_break3_copy1')->dropDownList($model->matchTiesByList, ['value' => 4])->hiddenInput()->label(false) ?>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if (Yii::$app->user->can('updateTournament', ['model' => $model]) && $model->status >= 3 && $model->status <= Tournament::STATUS_FINISHED && !$model->isNewRecord): ?>
            <?= Html::a(Yii::t('app', 'Reset'), ['reset', 'id' => $model->id], [
                'class' => 'btn btn-default',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to reset this tournament?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(Yii::t('app', 'Abort'), ['abort', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to abort this tournament?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
