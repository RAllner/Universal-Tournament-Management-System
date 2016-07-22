<?php

use frontend\models\Player;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Participant */
/* @var $form yii\widgets\ActiveForm */
/* @var $source array */

?>

<div class="participant-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-xs-5">
                <?= $form->field($model, 'name')->textInput() ?>
            </div>
            <div class="col-xs-5">
                <?= $form->field($model, 'player_id')->widget(\yii\jui\AutoComplete::classname(), [
                    'clientOptions' => [
                        'source' => $source,
                    ],
                ]) ?>
            </div>
            <div class="col-xs-2">
                <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
