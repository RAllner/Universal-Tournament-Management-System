<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Hall Of Fame';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'],['alt' =>$photoInfo['alt'], 'width' => '100%']);
$options = ['data-lightbox'=>'news-image','data-title'=>$photoInfo['alt']];
?>

<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="padding-left: 0">
    <div class="well bs-component">
        <figure style="text-align: center">
            <?= Html::a($photo, $photoInfo['url'], $options) ?>
        </figure>

        <h3>
            <?= $model->playername ?>

        </h3>
        <h4>Achievements:</h4>
        <p>   <?= $model->achievements ?></p>
        <h4>Description:</h4>
        <p>   <?= $model->description ?></p>
    </div>
</div>