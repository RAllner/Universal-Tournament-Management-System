<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Galleries */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$imageInfos = $model->ImageInfos;


?>
<div class="galleries-view">

    <h1><?= Html::encode($this->title);
        echo " (" . $model->ImageCount . " Bilder)";
        ?>
        <div class="pull-right">


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
            <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </h1>
    <div class="clearfix"></div>

    <div class="col-lg-12 well bs-component">


        <?php
        if ($model->ImageCount != 0) {
            $fotorama = \metalguardian\fotorama\Fotorama::begin(
                [
                    'options' => [
                        'loop' => true,
                        'hash' => true,
                        'width' => '100%',
                        'height' => '80%',
                        'nav' => 'thumbs',
                        'data-ratio' => '800/600',
                        'allowfullscreen' => true
                    ],
                    'spinner' => [
                        'lines' => 20,
                    ],
                    'tagName' => 'span',
                    'useHtmlData' => false,

                    'htmlOptions' => [
                        'class' => $model->id,
                        'id' => $model->id,
                    ],
                ]
            );

            for ($i = 0; $i < $model->ImageCount; $i++) {
                echo "<a href='" . $imageInfos['imageUrls'][$i] . "'><img src='" . $imageInfos['thumbsUrls'][$i] . "'></a>";
            }

            $fotorama->end();
        }
        ?>

        </br>
    <span class="pull-right">
        <h4>
            <span class="label label-default <?= CssHelper::generalCategoryCss($model->categoryName)?>"><?php echo $model->categoryName ?></span>
        </h4>
    </span>
        <p>
            <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
            <i class="material-icons">schedule</i> <?= Yii::t('app', 'Published on') . ' ' . date('d.m.Y, G:i', $model->created_at). ' '.Yii::t('app','o\' clock') ?>

        </p>
        <p>
            <?= $model->summary ?>
        </p>


    </div>
</div>
