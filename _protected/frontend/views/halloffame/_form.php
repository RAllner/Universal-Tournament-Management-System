<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Players;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Halloffame */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'playername')->textInput(['maxlength' => 255]) ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, "players_id")->dropDownList(ArrayHelper::map(Players::find()->all(), 'id', 'name'),['prompt'=>'Select...'])->hint(Yii::t('app', 'Select an existing Player to link him with this member. This is not required.')); ?>
        </div>
        <div class="col-lg-6">
        <?= $form->field($model, 'imageFile')->fileInput() ?>
            </div>
    </div>

    <?= $form->field($model, 'achievements')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(),
        ['editorOptions' => ['preset' => 'full', 'inline' => false]]); ?>

    <div class="row">
        <div class="col-lg-6">

            <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>

            <?= $form->field($model, 'category')->dropDownList($model->categoryList) ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord
            ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), ['article/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
