<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Hall Of Fame';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'],['alt' =>$photoInfo['alt'], 'style:' => 'height: 150px','class'=>'media-object']);
$options = ['data-lightbox'=>'news-image','data-title'=>$photoInfo['alt']];
?>

<div class="col-xs-12">
    <div class="media">
        <div class="media-left">
                <?= Html::a($photo, $photoInfo['url'], $options) ?>
        </div>
        <div class="media-body well">
            <h2>
                <?= $model->playername ?>
            </h2>
            <h4><?= Yii::t('app', 'Achievements')?>:</h4>
            <p>   <?= $model->achievements ?></p>
            <h4><?= Yii::t('app', 'Description') ?>:</h4>
            <p>   <?= $model->description ?></p>
        </div>
    </div>
</div>