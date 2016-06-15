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
        <h1>UTMS Alpha 0.1</h1>

        <h2>Universal Tournament Management System</h2>

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
    <h2><?= Yii::t('app', 'news')?></h2>
    <div class="well bs-component">
        <h3>
            <?= $model->title ?>

        </h3>
        <p class="time">
            <i class="material-icons">account_circle</i> <?= Yii::t('app', 'Author') . ' ' . $model->authorName ?>
            <i class="material-icons">schedule</i> <?= Yii::t('app', 'Published on') . ' ' . date('F j, Y, g:i a', $model->created_at) ?>
            <a href=<?= Url::to(['article/view', 'id' => $model->id]) ?>>
                <i class="material-icons">chevron_right</i><?= yii::t('app', 'Details'); ?>
            </a>
        </p>


        <figure style="text-align: center">
            <?= Html::a($photo, $photoInfo['url'], $options) ?>
        </figure>
        <br>
        <p><?= $model->summary ?></p>
        <p><?= $model->content ?></p>
    </div>
</div>
<div class="col-md-4">
    <div class="well bs-component no-padding" style="margin: 0">
        <p style="text-align: center" class="with-padding">
            <a href="https://www.facebook.com/BarCraftHL/" class="external-link"><i
                    class="fa fa-facebook-official" aria-hidden="true"></i></a>
            <a href="https://twitter.com/BarCraftHL" class="external-link"><i
                    class="fa fa-twitter-square" aria-hidden="true"></i></a>
            <a href="https://www.youtube.com/channel/UC6Hb-1s-cjpVVgBLvgijoRQ" class="external-link"><i
                    class="fa fa-youtube-square" aria-hidden="true"></i></a>
            <a href="https://www.twitch.tv/barcrafthl" class="external-link"><i
                    class="fa fa-twitch" aria-hidden="true"></i></a>
            <a href="http://bchl.challonge.com/" class="external-link">
                <object href="http://bchl.challonge.com/" type="image/svg+xml" style="height: 1em"
                        data="<?= Url::to('@web/images/constant/icons/challonge.svg') ?>">Your browser does not
                    support SVGs
                </object>
            </a>
            <a href="http://wiki.teamliquid.net/hearthstone/Dorfkrug_Cup" class="external-link">
                <object type="image/svg+xml" style="height: 1em"
                        data="<?= Url::to('@web/images/constant/icons/liquidpedias.svg') ?>">Your browser does
                    not
                    support SVGs
                </object>
            </a>
        </p>
    </div>

    <a class="twitter-timeline"
       data-widget-id="643309100416278528"
       href="https://twitter.com/BarCraftHL"
       data-screen-name="BarCraftHL">
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
