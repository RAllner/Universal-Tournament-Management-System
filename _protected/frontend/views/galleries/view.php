<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Galleries */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$imageInfos = $model->ImageInfos;


?>
<div class="galleries-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    $fotorama = \metalguardian\fotorama\Fotorama::begin(
        [
            'options' => [
                'loop' => true,
                'hash' => true,
                'width' => '100%',
                'nav' => 'thumbs',
                'data-ratio'=>'800/600',
                'allowfullscreen'=>true
            ],
            'spinner' => [
                'lines' => 20,
            ],
            'tagName' => 'span',
            'useHtmlData' => false,

            'htmlOptions' => [
                'class' => 'custom-class',
                'id' => 'custom-id',
            ],
        ]
    );

    for ($i = 0; $i <= $model->ImageCount-1; $i++) {
        echo "<a href='".$imageInfos['imageUrls'][$i]."'><img src='".$imageInfos['thumbsUrls'][$i]."'></a>";
    }
    ?>

    <?php $fotorama->end(); ?>




    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => Yii::t('app', 'Author'),
                'value' => $model->authorName,
            ],
            'title',
            'summary:html',
            [
                'label' => Yii::t('app', 'Category'),
                'value' => $model->categoryName,
            ],
            'created_at:dateTime',
        ],
    ]) ?>
    <div class="pull-right">
        <?php if (Yii::$app->user->can('adminGallery')): ?>

            <?= Html::a(Yii::t('app', 'Back'), ['admin'], ['class' => 'btn btn-warning']) ?>

        <?php endif ?>

        <?php if (Yii::$app->user->can('updateGallery', ['model' => $model])): ?>

            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php endif ?>

        <?php if (Yii::$app->user->can('deleteGallery')): ?>

            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this gallery?'),
                    'method' => 'post',
                ],
            ]) ?>

        <?php endif ?>
    </div>
</div>
