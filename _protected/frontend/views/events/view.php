<?php

use common\helpers\CssHelper;
use frontend\models\Locations;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\Events */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$date = new DateTime($model->startdate);
$location = Locations::find()->where(['id' => $model->locations_id])->one();
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>
<div class="events-view">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1><?= Html::encode($this->title) ?>
                <div class="pull-right">


                    <?php if (Yii::$app->user->can('updateEventsAndLocations', ['model' => $model])): ?>

                        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                    <?php endif ?>

                    <?php if (Yii::$app->user->can('deleteEventsAndLocations')): ?>

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
            <div class="row">
                <div class="col-sm-2 no-padding-right-sm" style="text-align: center">
                    <div class=" wrap-event-date">
                        <div class="day">
                            <?=
                            $date->format('d');
                            ?>
                        </div>
                        <div class="month">
                            <?=
                            $date->format('M');
                            ?>
                        </div>
                        <div class="year">
                            <?=
                            $date->format('Y');
                            ?>
                        </div>
                    </div>
                    <div class=" wrap-event-time">
                        <div class="time start">
                            <i class="material-icons">play_arrow</i>
                            <?=
                            $date->format('H:i') . ' ' . Yii::t('app', 'o\' clock');
                            ?>
                        </div>

                        <?php if ($model->enddate != ""): ?>
                        <?php $enddate = new DateTime($model->enddate);
                        ?>
                        <?php if ($enddate->format('d-M-Y') != $date->format('d-M-Y')): ?>
                    </div>
                    <div class="wrap-event-date enddate">
                        <div class="day">
                            <?=
                            $enddate->format('d');
                            ?>
                        </div>
                        <div class="month">
                            <?=
                            $enddate->format('M');
                            ?>
                        </div>
                        <div class="year">
                            <?=
                            $enddate->format('Y');
                            ?>
                        </div>
                    </div>
                    <div class="wrap-event-time">
                        <?php endif ?>
                        <div class="time stop">
                            <i class="material-icons">stop</i>
                            <?=
                            $enddate->format('H:i') . ' ' . Yii::t('app', 'o\' clock');
                            ?>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-sm-10 no-padding-left-sm wrap-event-content">
                    <div class="event-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
                        <div class="intro-Text-wrap">
                            <span class="article-Category">
                <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . ' ' . $model->typeName . "</div>"; ?>
                </span>
                            <h1 class="articleTitle" itemprop="headline">
                                    <?= $model->name ?>
                                </h1>

                            <p class="introText" itemprop="description">
                <span class="pull-right">
                    <?php
                    if ($model->facebook != "") { ?>
                        <a class="event-link" href="<?= $model->facebook ?>"><i class="fa fa-facebook-official"
                                                                                aria-hidden="true"></i></a>
                    <?php }
                    if ($model->liquidpedia != "") { ?>
                        <a class="event-link" href="<?= $model->liquidpedia ?>"><img
                                src="<?= Url::to('@web/images/constant/icons/liquidpedias.png') ?>"></a>
                    <?php }
                    if ($model->challonge != "") { ?>
                        <a class="event-link" href="<?= $model->challonge ?>"><img
                                src="<?= Url::to('@web/images/constant/icons/challonge.png') ?>"></a>
                    <?php } ?>
                </span>
                                <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
                                <i class="material-icons">schedule</i> <?= Yii::t('app', 'Added on') . ' ' . date('d.m.Y, G:i', $model->created_at) . ' ' . Yii::t('app', 'o\' clock') ?>
                                </br>
                                <i class="material-icons">home</i> <?= Yii::t('app', 'Location') . ': ' . Html::a($location->name, Url::to(['locations/view', 'id' => $location->id])) . ' - ' . $location->adress . ' | ' . $location->citystate . ' | ' . $location->postalcode ?>
                            </p>
                        </div>
                    </div>
                    <div class="well bs-component">
                        <?= $model->description ?>
                        <?php
                        if ($model->game != "") {
                            echo '<p>' . Yii::t('app', 'Game played') . ': ' . $model->game . '</p>';
                        }
                        if ($model->partners != "") {
                            echo '<p>' . Yii::t('app', 'Partners') . ': ' . $model->partners . '</p>';
                        }
                        ?>
                        <div class="clearfix">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>