<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Galleries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="galleries-form">



    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="row">
<!--        --><?php //if(!$model->isNewRecord) {
//            $imageCount = $model->ImageCount;
//            if($imageCount>0){
//            $imageInfos = $model->ImageInfos;
//
//            $options = ['data-lightbox' => 'gallery-image'];
//
//            for ($i = 0; $i <= $imageCount - 1; $i++) {
//
//                echo '<div class="col-lg-3" style="text-align: center;  padding:0.5em"><a href="' . $imageInfos['imageUrls'][$i] . '" data-lightbox="gallery" ><img src="' . $imageInfos['imageUrls'][$i] . '" style="max-height:150px; max-width:100%"/></a></div>';
//                if (($i == 3) || ($i > 3 && (($i + 1) % 4 == 0))) {
//                    echo '<div class="clearfix"></div>';
//                }
//            }
//            }
//
//        }
//        ?>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'summary')->widget(CKEditor::className(),
        ['editorOptions' => [ 'preset' => 'full', 'inline' => false]]); ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>
            </div>
            <div class="col-lg-6">
            <?= $form->field($model, 'category')->dropDownList($model->categoryList) ?>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create')
            : Yii::t('app', 'Update'), ['class' => $model->isNewRecord
            ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['galleries/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
