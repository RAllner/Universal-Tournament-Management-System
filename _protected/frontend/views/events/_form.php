<?php

use frontend\models\Locations;
use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Events */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="events-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">

            <div class="input-group">
                <?= $form->field($model, 'locations_id')->dropDownList(ArrayHelper::map(Locations::find()->all(), 'id', 'name')) ?>
                <?= Html::a('<i class="material-icons">add</i>', ['locations/create'], ['class' => 'input-group-btn btn']) ?>
            </div>

        </div>
    </div>


    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'type')->dropDownList($model->typeList) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'category')->dropDownList($model->categoryList) ?>

        </div>
    </div>


    <div class="row">
        <div class="col-md-6">

           <?= $form->field($model, 'startdate')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => Yii::t('app', 'Enter event start time ... ')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii'

                ]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'enddate')->widget(DateTimePicker::classname(), [
                'options' => ['placeholder' => Yii::t('app', 'Enter event end time ... (if you want)')],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii'
                ]
            ]); ?>
        </div>
    </div>

    <h2>Optional</h2>
    <?= $form->field($model, 'description')->widget(CKEditor::className(),
        ['editorOptions' => ['preset' => 'standard', 'inline' => false]]); ?>


    <?= $form->field($model, 'imageFile')->fileInput() ?>

  <?= $form->field($model, 'tournaments_id')->textInput()->hint('http://example.de/example') ?>

    <?= $form->field($model, 'game')->textInput(['maxlength' => true])->hint('Hearthstone, Starcraft, ...') ?>

    <?= $form->field($model, 'partners')->textInput(['maxlength' => true])->hint('Gecko-Bar, Heimrat-HL, Blizzard, ...') ?>

    <h2>Links</h2>
    <div class="input-group">
        <span class="input-group-addon"><i class="material-icons">http</i></span>
        <?= $form->field($model, 'facebook')->textInput(['maxlength' => true])->hint('http://example.de/example') ?>
    </div>
    <div class="input-group">
        <span class="input-group-addon"><i class="material-icons">http</i></span>
        <?= $form->field($model, 'liquidpedia')->textInput(['maxlength' => true])->hint('http://example.de/example') ?>
    </div>
    <div class="input-group">
        <span class="input-group-addon"><i class="material-icons">http</i></span>
        <?= $form->field($model, 'challonge')->textInput(['maxlength' => true])->hint('http://example.de/example') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
