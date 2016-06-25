<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;
use frontend\models\Locations;

/* @var $this yii\web\View */
$this->title = 'Events';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
$date = new DateTime($model->startdate);
$location = Locations::find()->where(['id' => $model->locations_id])->one();
?>


<div class="row">
    <div class="col-sm-2" style="text-align: center">
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
                $date->format('h:s') . ' ' . Yii::t('app', 'o\' clock');
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
                $date->format('h:s') . ' ' . Yii::t('app', 'o\' clock');
                ?>
            </div>
            <?php endif ?>
        </div>
    </div>
    <div class="col-sm-10 wrap-event-content">
        <div class="event-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
            <div class="intro-Text-wrap">
                            <span class="article-Category">
                <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . ' ' . $model->typeName . "</div>"; ?>
                </span>
                <h1 class="articleTitle" itemprop="headline"><a
                        href=<?= Url::to(['events/view', 'id' => $model->id]) ?>>
                        <?= $model->name ?>
                    </a></h1>

                <p class="introText" itemprop="description">
                <span class="pull-right">
                    <?php
                       if ($model->facebook != "") { ?>
                          <a class="event-link" href="<?= $model->facebook ?>"><i class="fa fa-facebook-official"
                                                                                        aria-hidden="true"></i></a>
                          <?php }
                    if ($model->liquidpedia != "") { ?>
                        <a class="event-link" href="<?= $model->liquidpedia ?>"><img src="<?= Url::to('@web/images/constant/icons/liquidpedias.png')?>"></a>
                    <?php }
                    if ($model->challonge != "") { ?>
                        <a class="event-link" href="<?= $model->challonge ?>"><img src="<?= Url::to('@web/images/constant/icons/challonge.png')?>"></a>
                    <?php } ?>
                </span>
                    <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
                    <i class="material-icons">schedule</i> <?= Yii::t('app', 'Added on') . ' ' . date('d.m.Y, G:i', $model->created_at). ' '.Yii::t('app','o\' clock') ?>
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



        <span class="pull-right">
        <a class="btn btn-primary" href=<?= Url::to(['events/update', 'id' => $model->id]) ?>>
            <?php if (Yii::$app->user->can('updateEventsAndLocations')): ?>
                <?= yii::t('app', 'Update'); ?>
            <?php endif ?>
        </a>
            </span>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>


