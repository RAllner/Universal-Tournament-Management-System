<?php
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
$this->title = 'Organisations';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>

<div class="col-lg-12 well">
    <div class="media">
        <div class="media-left">

            <a href="<?= Url::to(['organisation/view', 'id' => $model->id]) ?>">
                <img class="media-object" style="width:100px" src="<?= $photoInfo['url'] ?>"
                     alt="<?= $model->name ?>">
            </a>
        </div>
        <div class="media-body media-middle">
            <h3 class="media-heading">
                <a href="<?= Url::to(['organisation/view', 'id' => $model->id]) ?>">
                    <?= $model->name ?>
                </a>
            </h3>
            <p>
                <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Owner') . ' ' . $model->authorName ?>
                <i class="material-icons">schedule</i> <?= Yii::t('app', 'Created on') . ' ' . date('d.m.Y, G:i', $model->created_at) . ' ' . Yii::t('app', 'o\' clock') ?>
            </p>
            <p>
                <i class="material-icons">people</i> <?= Yii::t('app', 'Members') . ' ' . count($model->organisationHasUsers) ?>
            </p>

        </div>
    </div>
</div>



