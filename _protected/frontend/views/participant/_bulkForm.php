<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 24.07.2016
 * Time: 19:08
 */

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $bulk frontend\models\Bulk */
?>
<div class="participant-bulkForm">
    <?php $form2 = ActiveForm::begin(); ?>
        <?= $form2->field($bulk, 'bulk')->textarea(['rows' => '6'])->hint(Yii::t('app', 'Enter several participant names separated by line breaks.')) ?>
        <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
</div>


