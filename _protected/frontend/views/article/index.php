<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', Yii::$app->name) . ' ' . Yii::t('app', 'news');
$this->params['breadcrumbs'][] = Yii::t('app', 'Articles');
?>

<div class="article-index">

    <h1><?= Html::encode($this->title) ?>
        <span class="pull-right">
        <?php if (Yii::$app->user->can('createArticle')): ?>
            <?= Html::a('<i class="material-icons">create</i> ' . Yii::t('app', 'Create Article'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif ?>
        <?php if (Yii::$app->user->can('adminArticle')): ?>
            <?= Html::a(Yii::t('app', 'Admin'), ['admin'], ['class' => 'btn btn-warning']) ?>
        <?php endif ?>
            </span>
    </h1>

    <div class="clearfix"></div>
    <div class="row">
    <div class="col-lg-8 no-padding-left " style="padding-left: 0">


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
               data-tweet-limit="6"
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
    </div>
</div>
