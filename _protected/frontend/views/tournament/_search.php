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


    <div class="input-group">

        <?php echo $form->field($model, 'name') ?>
        <span class="input-group-addon">
            <div class="btn-group" role="toolbar" aria-label="search" style="display: inline-flex">
                <button  type="submit" class="btn btn-primary"><i class="material-icons">search</i>
                </button>
                <button  type="reset" class="btn btn-danger"><i class="material-icons">remove</i></button>
            </div>
        </span>
    </div>


    <?php ActiveForm::end(); ?>

</div>
