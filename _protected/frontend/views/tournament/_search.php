<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\TournamentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tournament-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>



    <?php echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'begin') ?>

    <?php // echo $form->field($model, 'end') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'max_participants') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'has_sets') ?>

    <?php // echo $form->field($model, 'participants_count') ?>

    <?php // echo $form->field($model, 'stage_type') ?>

    <?php // echo $form->field($model, 'first_stage') ?>

    <?php // echo $form->field($model, 'fs_format') ?>

    <?php // echo $form->field($model, 'fs_third_place') ?>

    <?php // echo $form->field($model, 'fs_de_grand_finals') ?>

    <?php // echo $form->field($model, 'fs_rr_ranked_by') ?>

    <?php // echo $form->field($model, 'fs_rr_ppmw') ?>

    <?php // echo $form->field($model, 'fs_rr_ppmt') ?>

    <?php // echo $form->field($model, 'fs_rr_ppgw') ?>

    <?php // echo $form->field($model, 'fs_rr_ppgt') ?>

    <?php // echo $form->field($model, 'fs_s_ppb') ?>

    <?php // echo $form->field($model, 'participants_compete') ?>

    <?php // echo $form->field($model, 'participants_advance') ?>

    <?php // echo $form->field($model, 'gs_format') ?>

    <?php // echo $form->field($model, 'gs_rr_ranked_by') ?>

    <?php // echo $form->field($model, 'gs_rr_ppmw') ?>

    <?php // echo $form->field($model, 'gs_rr_ppmt') ?>

    <?php // echo $form->field($model, 'gs_rr_ppgw') ?>

    <?php // echo $form->field($model, 'gs_rr_ppgt') ?>

    <?php // echo $form->field($model, 'gs_tie_break1') ?>

    <?php // echo $form->field($model, 'gs_tie_break2') ?>

    <?php // echo $form->field($model, 'quick_advance') ?>

    <?php // echo $form->field($model, 'gs_tie_break3') ?>

    <?php // echo $form->field($model, 'gs_tie_break1_copy1') ?>

    <?php // echo $form->field($model, 'gs_tie_break2_copy1') ?>

    <?php // echo $form->field($model, 'gs_tie_break3_copy1') ?>

    <?php // echo $form->field($model, 'notifications') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
