<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\helpers\CssHelper;

/* @var $this yii\web\View */
$this->title = 'Articles';
$photoInfo = $model->PhotoInfo;
$photo = Html::img($photoInfo['url'], ['alt' => $photoInfo['alt']]);
$options = ['data-lightbox' => 'news-image', 'data-title' => $photoInfo['alt']];
?>

<div class="col-md-8" style="padding-left: 0">
    <div class="jumbotron">
        <p class="lead">                <?php echo Yii::t('app', 'Wellcome');
            if (!Yii::$app->user->isGuest) {
                echo "<b>" . Yii::$app->user->identity->username . "</b>";
            }
            echo Yii::t('app', 'on the new Platform for your Tournament!') ?></p>
        </br>
        <?php
        if (Yii::$app->user->isGuest) {

            ?>


            <div class="btn-group">
                <a class="btn btn-primary" href="../site/login"><?php echo Yii::t('app', 'Login'); ?></a>
                <a class="btn btn-default" href="../site/signup"><?php echo Yii::t('app', 'Signup'); ?></a>
            </div>
            <?php
        }
        ?>
    </div>
    <h2><?= Yii::t('app', 'news') ?></h2>

    <div class="article-image-wrap" style="background-image: url('<?= $photoInfo['url'] ?>')">
        <div class="intro-Text-wrap">
                <span class="article-Category">
                <?php echo "<div class='" . CssHelper::generalCategoryCss($model->categoryName) . "'>" . $model->categoryName . "</div>"; ?>
                </span>

            <h1 class="articleTitle" itemprop="headline"><a href=<?= Url::to(['article/view', 'id' => $model->id]) ?>>
                    <?= $model->title ?>
                </a></h1>

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
</div>
<div class="col-md-4 no-padding-left no-padding-right">
    <div class="well bs-component no-padding external-link-bar">
            <a href="https://www.facebook.com/BarCraftHL/" class="external-link col-lg-2"><i
                    class="fa fa-facebook-official" aria-hidden="true"></i></a>
            <a href="https://twitter.com/BarCraftHL" class="external-link col-lg-2"><i
                    class="fa fa-twitter-square" aria-hidden="true"></i></a>
            <a href="https://www.youtube.com/channel/UC6Hb-1s-cjpVVgBLvgijoRQ" class="external-link col-lg-2"><i
                    class="fa fa-youtube-square" aria-hidden="true"></i></a>
            <a href="https://www.twitch.tv/barcrafthl" class="external-link col-lg-2"><i
                    class="fa fa-twitch" aria-hidden="true"></i></a>
            <a href="http://bchl.challonge.com/" class="external-link col-lg-2">
                <img src="<?= Url::to('@web/images/constant/icons/challonge.png') ?>">
                </img>
            </a>
            <a href="http://wiki.teamliquid.net/hearthstone/Dorfkrug_Cup" class="external-link col-lg-2">
                <img  src="<?= Url::to('@web/images/constant/icons/liquidpedias.png') ?>">
                </img>
                </object>
            </a>

    </div>

    <div class="well bs-component no-padding" style="margin: 0">
        <a class="twitter-timeline"
           data-widget-id="643309100416278528"
           href="https://twitter.com/BarCraftHL"
           data-screen-name="BarCraftHL"
           data-theme="dark"
           data-tweet-limit="4"
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
