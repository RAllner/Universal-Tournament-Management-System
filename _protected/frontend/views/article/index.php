<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', Yii::$app->name) . ' ' . Yii::t('app', 'news');
$this->params['breadcrumbs'][] = Yii::t('app', 'Articles');
?>

<div class="article-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="small"> - <?= Yii::t('app', 'The best news available') ?></span>
                <span class="pull-right">
        <?php if (Yii::$app->user->can('adminArticle')): ?>

            <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>

        <?php endif ?>
            </span>
    </h1>
    <div class="clearfix"></div>
    <div class="col-lg-8" style="padding-left: 0">


        <?= ListView::widget([
            'summary' => false,
            'dataProvider' => $dataProvider,
            'emptyText' => Yii::t('app', 'We haven\'t created any articles yet.'),
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_index', ['model' => $model]);
            },
        ]) ?>

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
                            data="<?= Url::to('@web/images/constant/icons/liquidpedias.svg') ?>">Your browser does not
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
</div>
