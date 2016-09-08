<?php

use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Player */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="player-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'description')->widget(CKEditor::className(),
                ['editorOptions' => [ 'preset' => 'standard', 'inline' => false]]); ?>
        </div>
        <div class="col-md-6">
            <label class="radio-head">Gender</label>
            <?=
            $form->field($model, 'gender')
                ->radioList(
                    [2 => ' Male', 1 => ' Female', 0 => ' Other'],
                    [
                        'item' => function($index, $label, $name, $checked, $value) {

                            $return = '<label class="modal-radio">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            $return .= '<i></i>';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';

                            return $return;
                        }
                    ]
                )
                ->label(false);
            ?>
            <div class="input-group">
                <span class="input-group-addon"><i class="material-icons">http</i></span>
                <?= $form->field($model, 'website')->textInput(['maxlength' => true])->hint('http://example.de/example')?>
            </div>

            <?= $form->field($model, 'stream')->textInput(['maxlength' => true])->hint('Your channel name: http://twitch.tv/CHANNELNAME') ?>
            <?= $form->field($model, 'imageFile')->fileInput() ?>
            <?= $form->field($model, 'games')->textInput(['maxlength' => true])->hint('Hearthstone, Starcraft 2, CS:GO, ...') ?>
            <?= $form->field($model, 'languages')->textInput(['maxlength' => true])->hint('E.g. english, german, french') ?>
            <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => Yii::t('app', 'Enter your birthday ')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'

                ]
            ])->hint(Yii::t('app', 'You can ignore the exact time. Only your age will be displayed.')); ?>
            <?= $form->field($model, 'nation')->dropDownList($model->nationList) ?>
        </div>
    </div>






    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['player/own-index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
