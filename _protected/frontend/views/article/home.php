<?php
use frontend\models\Locations;
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;
use frontend\models\Events;

/* @var $this yii\web\View */
$this->title = 'BarCraft HL';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt']]);
$options = ['data-lightbox' => 'news-image', 'data-title' => $photoInfo['alt']];

$nextEvent = Events::find()->orderBy(['startdate' => SORT_ASC])->one();
$date = new DateTime($nextEvent->startdate);
$location = Locations::find()->where(['id' => $nextEvent->locations_id])->one();
$photoInfo = $nextEvent->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt'], 'width' => '100%']);
$options = ['data-title' => $photoInfo['alt']];
?>

<ol class="breadcrumb">
    <li class="active">Home</li>
</ol>
<div class="col-md-8" style="padding-left: 0">

    <?php
    if (Yii::$app->user->isGuest) {

    ?>
    <div class="jumbotron">
        <h1><b><img src="<?= Url::to('@web/images/constant/logo-golds.png')?>"/> BarCraft HL <img src="<?= Url::to('@web/images/constant/logo-golds.png')?>"/></b></h1>
        <p class="lead">
            <?= Yii::t('app', 'Wellcome'). ' '.Yii::t('app', 'on the new Platform for your Tournament!')?>
            </p>
        </br>

                <a class="btn btn-primary" href="<?= Url::to('@web/site/login')?>"><?php echo Yii::t('app', 'Login'); ?></a>

    </div>
        <?php
    }
    ?>
    <div class="article-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
        <div class="intro-Text-wrap">
                <span class="article-Category">
                <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . "</div>"; ?>
                </span>

            <h2 class="articleTitle" itemprop="headline"><a href=<?= Url::to(['article/view', 'id' => $model->id]) ?>>
                    <?= $model->title ?>
                </a></h2>

            <p class="introText" itemprop="description">
                <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
                <i class="material-icons">schedule</i> <?= Yii::t('app', 'Published on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
            </p>
        </div>
    </div>
    <div class="well bs-component">

        <p><?= $model->summary ?></p>
        <span class="pull-right">
    <a class="btn btn-primary" href=<?= Url::to(['article/view', 'id' => $model->id]) ?>>
        <?= yii::t('app', 'Read more'); ?><i class="material-icons">chevron_right</i>
    </a>
            </span>
        <div class="clearfix"></div>


    </div>
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

                <?php if ($nextEvent->enddate != ""): ?>
                <?php $enddate = new DateTime($nextEvent->enddate);
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
                <?php echo "<div class='" . CssHelper::generalCategoryCss($nextEvent->categoryName) . "'>" . $nextEvent->categoryName . ' ' . $nextEvent->typeName . "</div>"; ?>
                </span>
                    <h1 class="articleTitle" itemprop="headline"><a
                            href=<?= Url::to(['events/view', 'id' => $nextEvent->id]) ?>>
                            <?= $nextEvent->name ?>
                        </a></h1>

                    <p class="introText" itemprop="description">
                <span class="pull-right">
                    <?php
                    if ($nextEvent->facebook != "") { ?>
                        <a class="event-link" href="<?= $nextEvent->facebook ?>"><i class="fa fa-facebook-official"
                                                                                aria-hidden="true"></i></a>
                    <?php }
                    if ($nextEvent->liquidpedia != "") { ?>
                        <a class="event-link" href="<?= $nextEvent->liquidpedia ?>"><img
                                src="<?= Url::to('@web/images/constant/icons/liquidpedias.png') ?>"></a>
                    <?php }
                    if ($nextEvent->challonge != "") { ?>
                        <a class="event-link" href="<?= $nextEvent->challonge ?>"><img
                                src="<?= Url::to('@web/images/constant/icons/challonge.png') ?>"></a>
                    <?php } ?>
                </span>
                        <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $nextEvent->authorName ?>
                        <i class="material-icons">schedule</i> <?= Yii::t('app', 'Added on') . ' ' . date('d.m.Y, G:i', $nextEvent->created_at) . ' ' . Yii::t('app', 'o\' clock') ?>
                        </br>
                        <i class="material-icons">home</i> <?= Yii::t('app', 'Location') . ': ' . Html::a($location->name, Url::to(['locations/view', 'id' => $location->id])) . ' - ' . $location->adress . ' | ' . $location->citystate . ' | ' . $location->postalcode ?>
                    </p>
                </div>
            </div>
            <div class="well bs-component">
                <?= $nextEvent->description ?>
                <?php
                if ($nextEvent->game != "") {
                    echo '<p>' . Yii::t('app', 'Game played') . ': ' . $nextEvent->game . '</p>';
                }
                if ($nextEvent->partners != "") {
                    echo '<p>' . Yii::t('app', 'Partners') . ': ' . $nextEvent->partners . '</p>';
                }
                ?>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4 no-padding-left no-padding-right">

    <div class="btn-group btn-group-justified external" role="group" aria-label="Justified button group">
        <a href="https://www.facebook.com/BarCraftHL/" class="btn btn-default"><i
                class="fa fa-facebook-official" aria-hidden="true"></i></a>
        <a href="https://twitter.com/BarCraftHL" class="btn btn-default"><i
                class="fa fa-twitter-square" aria-hidden="true"></i></a>
        <a href="https://www.youtube.com/channel/UC6Hb-1s-cjpVVgBLvgijoRQ" class="btn btn-default"><i
                class="fa fa-youtube-square" aria-hidden="true"></i></a>
        <a href="http://twitch.tv/barcrafthl" class="btn btn-default"><i
                class="fa fa-twitch" aria-hidden="true"></i></a>
        <a href="http://bchl.challonge.com/" class="btn btn-default">
            <img src="<?= Url::to('@web/images/constant/icons/challonge.png') ?>">
            </img>
        </a>
        <a href="http://wiki.teamliquid.net/hearthstone/Dorfkrug_Cup" class="btn btn-default">
            <img src="<?= Url::to('@web/images/constant/icons/liquidpedias.png') ?>">
            </img>
            </object>
        </a>
    </div>


    <div class="well bs-component no-padding-left no-padding-right" style="margin: 0; text-align: center">
        <h2> <i
                class="fa fa-twitter-square" aria-hidden="true"></i> Twitter Feed</h2>
        <a class="twitter-timeline"
           data-widget-id="643309100416278528"
           href="https://twitter.com/BarCraftHL"
           data-screen-name="BarCraftHL"
           data-theme="dark"
           data-tweet-limit="3"
           data-link-color="#ffad24"
           data-chrome="transparent noheader nofooter"
        >
            Tweets by @BarCraftHL

        </a>
        <script>!function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + "://platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, "script", "twitter-wjs");</script>
    </div>
</div>
