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

<div class="col-lg-12 no-padding-left no-padding-right">

    <div class="article-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
        <div class="intro-Text-wrap">
            <h1 class="articleTitle" itemprop="headline"><a href=<?= Url::to(['locations/view', 'id' => $model->id]) ?>>
                    <?= $model->name ?>
                </a></h1>

            <p class="introText" itemprop="description">
                <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
                <i class="material-icons">schedule</i> <?= Yii::t('app', 'Published on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
            </p>
        </div>
    </div>
    <div class="well bs-component">
        <p><?= $model->adress ?></p>
        <p><?= $model->citystate ?></p>
        <p><?= $model->postalcode ?></p>
        <p><?= $model->description ?></p>

        <span class="pull-right">
    <a class="btn btn-primary" href=<?= Url::to(['locations/update', 'id' => $model->id]) ?>>
        <?php if (Yii::$app->user->can('updateEventsAndLocations')): ?>
        <?= yii::t('app', 'Update'); ?><i class="material-icons">chevron_right</i>
        <?php endif ?>
    </a>
            </span>
        <div class="clearfix"></div>


    </div>

</div>


