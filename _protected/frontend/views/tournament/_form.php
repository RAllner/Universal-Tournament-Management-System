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
        <?= $form->field($model, 'is_team_tournament')->checkbox($readOnly)->hint(Yii::t('app', 'Do teams compete in your tournament?')) ?>

        <?= $form->field($model, 'stage_type')->radioList([0 => Yii::t('app', 'Single Stage Tournament'), 1 => Yii::t('app', 'Two Stage Tournament')], $readOnly)->hint(Yii::t('app', 'Do you need a group stage to reduce the participants early?')) ?>


        <div class="group-stage">
            <div class="well">
                <h3><?= Yii::t('app', 'Group Stage') ?></h3>
                <div class="row">
                    <div class="col-md-6">

                        <?= $form->field($model, 'gs_format')->dropDownList($model->groupStageFormatList, $readOnly)->hint(
                            '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="' . Yii::t('app', 'Single Elimination') . '" data-content="' . Yii::t('app', 'A single-elimination tournament—also called an Olympic system tournament, a knockout (or, knock-out), single penetration, or sudden death tournament—is a type of elimination tournament where the loser of each bracket is immediately eliminated from winning the championship or first prize in the event.') . '">' . Yii::t('app', 'Single Elimination') . '</a> | '
                            . '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="' . Yii::t('app', 'Double Elimination') . '" data-content="' . Yii::t('app', 'A double-elimination tournament is a type of elimination tournament competition in which a participant ceases to be eligible to win the tournament\'s championship upon having lost two games or matches. It stands in contrast to a single-elimination tournament, in which only one defeat results in elimination.') . '">' . Yii::t('app', 'Double Elimination') . '</a> | '
                            . '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="' . Yii::t('app', 'Round Robin') . '" data-content="' . Yii::t('app', 'A round-robin tournament (or all-play-all tournament) is a competition in which each contestant meets all other contestants in turn.') . '">' . Yii::t('app', 'Round Robin') . '</a> | '
                            . '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="' . Yii::t('app', 'Swiss') . '" data-content="' . Yii::t('app', 'A Swiss-system tournament is a non-eliminating tournament format which features a predetermined number of rounds of competition, but considerably fewer than in a round-robin tournament. In a Swiss tournament, each competitor (team or individual) does not play every other. Competitors meet one-to-one in each round and are paired using a predetermined set of rules designed to ensure that each competitor plays opponents with a similar running score, but not the same opponent more than once. The winner is the competitor with the highest aggregate points earned in all rounds. All competitors play in each round unless there is an odd number of them.') . '">' . Yii::t('app', 'Swiss') . '</a> '
                        )
                        ?>

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

                        <?= $form->field($model, 'fs_format')->dropDownList($model->formatList, $readOnly)->hint(
                            '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="' . Yii::t('app', 'Single Elimination') . '" data-content="' . Yii::t('app', 'A single-elimination tournament—also called an Olympic system tournament, a knockout (or, knock-out), single penetration, or sudden death tournament—is a type of elimination tournament where the loser of each bracket is immediately eliminated from winning the championship or first prize in the event.') . '">' . Yii::t('app', 'Single Elimination') . '</a> | '
                            . '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="' . Yii::t('app', 'Double Elimination') . '" data-content="' . Yii::t('app', 'A double-elimination tournament is a type of elimination tournament competition in which a participant ceases to be eligible to win the tournament\'s championship upon having lost two games or matches. It stands in contrast to a single-elimination tournament, in which only one defeat results in elimination.') . '">' . Yii::t('app', 'Double Elimination') . '</a> | '
                            . '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="' . Yii::t('app', 'Round Robin') . '" data-content="' . Yii::t('app', 'A round-robin tournament (or all-play-all tournament) is a competition in which each contestant meets all other contestants in turn.') . '">' . Yii::t('app', 'Round Robin') . '</a> | '
                            . '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="' . Yii::t('app', 'Swiss') . '" data-content="' . Yii::t('app', 'A Swiss-system tournament is a non-eliminating tournament format which features a predetermined number of rounds of competition, but considerably fewer than in a round-robin tournament. In a Swiss tournament, each competitor (team or individual) does not play every other. Competitors meet one-to-one in each round and are paired using a predetermined set of rules designed to ensure that each competitor plays opponents with a similar running score, but not the same opponent more than once. The winner is the competitor with the highest aggregate points earned in all rounds. All competitors play in each round unless there is an odd number of them.') . '">' . Yii::t('app', 'Swiss') . '</a> '
                        ) ?>

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
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#misc"
                                                  aria-controls="misc" role="tab"
                                                  data-toggle="tab"><?= Yii::t('app', 'Misc') ?></a></li>
        <li role="presentation"><a href="#status" aria-controls="status" role="tab"
                                   data-toggle="tab"><?= Yii::t('app', 'Tournament Status') ?></a></li>
        <li role="presentation"><a href="#tiebreak" aria-controls="tiebreak" role="tab"
                                   data-toggle="tab"><?= Yii::t('app', 'Tiebreaker') ?></a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="misc">
            <div class="well">
                <?= $form->field($model, 'quick_advance')->checkbox($readOnly) ?>

                <?= $form->field($model, 'has_sets')->checkbox($readOnly) ?>

                <?= $form->field($model, 'notifications')->checkbox() ?>

                <?= $form->field($model, 'url')->hiddenInput()->label(false) ?>

                <?php if ($model->isNewRecord): ?>
                    <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>
                <?php endif ?>

                <?= $form->field($model, 'max_participants')->textInput(['type' => 'number', 'min' => 2, 'value' => 50]) ?>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="status">
            <div class="well">
                <?php if(Yii::$app->user->can('updateTournament', ['model' => $model])): ?>
                <?php if ($model->status >= 3 && $model->status <= Tournament::STATUS_FINISHED && !$model->isNewRecord): ?>
                    <?= Html::a(Yii::t('app', 'Reset'), ['reset', 'id' => $model->id], [
                        'class' => 'btn btn-warning',
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
                <?php if ($model->status == Tournament::STATUS_ABORT && !$model->isNewRecord): ?>
                        <?= Html::a(Yii::t('app', 'Resume'), ['reopen', 'id' => $model->id], [
                            'class' => 'btn btn-warning',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to resume this tournament?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                <?php endif ?>
                <?php endif ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this tournament?'),
                        'method' => 'post',
                    ],
                ]) ?>

            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tiebreak">
            <div class="well">
                <?= $form->field($model, 'gs_tie_break1')->dropDownList($model->matchTiesByList, ['value' => 6])->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'gs_tie_break2')->dropDownList($model->matchTiesByList, ['value' => 2])->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'gs_tie_break3')->dropDownList($model->matchTiesByList, ['value' => 4])->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'gs_tie_break1_copy1')->dropDownList($model->matchTiesByList, ['value' => 6])->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'gs_tie_break2_copy1')->dropDownList($model->matchTiesByList, ['value' => 2])->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'gs_tie_break3_copy1')->dropDownList($model->matchTiesByList, ['value' => 4])->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'organisation_id')->hiddenInput()->label(false) ?>

                <?= $form->field($model, 'participants_count')->hiddenInput()->label(false) ?>
            </div>
        </div>
    </div>


</div>


<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
