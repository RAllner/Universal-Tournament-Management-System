<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Locations */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>
<div class="location-view">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?php if (Yii::$app->user->can('updateEventsAndLocations', ['model' => $model])): ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('deleteEventsAndLocations', ['model' => $model])): ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
        <?= Html::a('<i class="material-icons">view_headline</i> ' . Yii::t('app', 'Overview'), ['index'], ['class' => 'btn btn-default']) ?>

    </span>
    </h1>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-lg-8">
            <div class="location-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
                <div class="intro-Text-wrap">
                    <h1 class="articleTitle" itemprop="headline">
                            <?= $model->name ?>
                        </h1>

                    <p class="introText" itemprop="description">
                        <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
                        <i class="material-icons">schedule</i> <?= Yii::t('app', 'Added on') . ' ' . date('d.m.Y, G:i', $model->created_at) . ' ' . Yii::t('app', 'o\' clock') ?>
                    </p>
                </div>
            </div>
            <div class="well bs-component">
                <?= $model->description ?>
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

                <?php if (!is_null($model->maps_url)): ?>
                    <iframe
                        src="<?= $model->maps_url ?>"
                        width="100%" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>
