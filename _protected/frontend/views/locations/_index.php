<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Locations';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>

<div class="col-lg-6">

    <div class="location-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
        <div class="intro-Text-wrap">
            <h1 class="articleTitle" itemprop="headline"><a href=<?= Url::to(['locations/view', 'id' => $model->id]) ?>>
                    <?= $model->name ?>
                </a></h1>

            <p class="introText" itemprop="description">
                <i class="material-icons">schedule</i> <?= Yii::t('app', 'Added on') . ' ' . date('d.m.Y, G:i', $model->created_at). ' '.Yii::t('app','o\' clock') ?>
            </p>
        </div>
    </div>
    <div class="well bs-component">

        <table class="col-lg-12">
            <tbody>
            <tr>
                <th>
                    <?= Yii::t('app', 'Street') ?>
                </th>
                <td>
                    <?= $model->adress ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?= Yii::t('app', 'City') ?>
                </th>
                <td>
                    <?= $model->citystate ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?= Yii::t('app', 'Postcode') ?>
                </th>
                <td>
                    <?= $model->postalcode ?>
                </td>
            </tr>
            </tbody>
        </table>



        <span class="pull-right">
        <a class="btn btn-primary" href=<?= Url::to(['locations/update', 'id' => $model->id]) ?>>
            <?php if (Yii::$app->user->can('updateEventsAndLocations')): ?>
                <?= yii::t('app', 'Update'); ?>
            <?php endif ?>
        </a>
            </span>
        <div class="clearfix"></div>


    </div>

</div>


