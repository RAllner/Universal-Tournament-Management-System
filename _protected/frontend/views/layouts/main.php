<?php
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="apple-touch-icon" sizes="57x57" href="<?= Url::to("@web/images/favicon/apple-touch-icon-57x57.png") ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= Url::to("@web/images/favicon/apple-touch-icon-60x60.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= Url::to("@web/images/favicon/apple-touch-icon-72x72.png") ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= Url::to("@web/images/favicon/apple-touch-icon-76x76.png") ?>">
    <link rel="apple-touch-icon" sizes="114x114"
          href="<?= Url::to("@web/images/favicon/apple-touch-icon-114x114.png") ?>">
    <link rel="apple-touch-icon" sizes="120x120"
          href="<?= Url::to("@web/images/favicon/apple-touch-icon-120x120.png") ?>">
    <link rel="apple-touch-icon" sizes="144x144"
          href="<?= Url::to("@web/images/favicon/apple-touch-icon-144x144.png") ?>">
    <link rel="apple-touch-icon" sizes="152x152"
          href="<?= Url::to("@web/images/favicon/apple-touch-icon-152x152.png") ?>">
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?= Url::to("@web/images/favicon/apple-touch-icon-180x180.png") ?>">
    <link rel="icon" type="image/png" href="<?= Url::to("@web/images/favicon/favicon-32x32.png") ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= Url::to("@web/images/favicon/android-chrome-192x192.png") ?>"
          sizes="192x192">
    <link rel="icon" type="image/png" href="<?= Url::to("@web/images/favicon/favicon-96x96.png") ?>" sizes="96x96">
    <link rel="icon" type="image/png" href="<?= Url::to("@web/images/favicon/favicon-16x16.png") ?>" sizes="16x16">
    <link rel="manifest" href="<?= Url::to("@web/images/favicon/manifest.json") ?>">
    <link rel="mask-icon" href="<?= Url::to("@web/images/favicon/safari-pinned-tab.svg") ?>" color="#031d24">
    <link rel="shortcut icon" href="<?= Url::to("@web/images/favicon/favicon.ico") ?>">
    <meta name="apple-mobile-web-app-title" content="BarCraft HL">
    <meta name="application-name" content="BarCraft HL"
    ">
    <meta name="msapplication-TileColor" content="#181818">
    <meta name="msapplication-TileImage" content="<?= Url::to("@web/images/favicon/mstile-144x144.png") ?>">
    <meta name="msapplication-config" content="<?= Url::to("@web/images/favicon/browserconfig.xml") ?>">
    <meta name="theme-color" content="#ffffff">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="' . Url::to("@web/images/constant/logo-golds.png") . '" class="logo"/> <b>' . Yii::$app->name . '</b>',
        'brandUrl' => Yii::$app->homeUrl,

        'options' => [
            'class' => 'navbar-nav navbar-fixed-top',

        ],
    ]);


    $menuItems[] = ['label' => '<span class="glyphicon glyphicon-home"></span>', 'url' => ['/article/home']];
    $menuItems[] = ['label' => '<i class="material-icons">gamepad</i> ' . Yii::t('app', 'Tournaments'), 'url' => ['/tournament/index']];
    $menuItems[] = ['label' => '<i class="material-icons">chrome_reader_mode</i> ' . Yii::t('app', 'News'), 'url' => ['/article/index']];
    $menuItems[] = ['label' => '<i class="material-icons">event</i> ' . Yii::t('app', 'Events'), 'url' => ['/events/index']];
    $menuItems[] = ['label' => '<i class="material-icons">play_arrow</i> ' . Yii::t('app', 'Media'),
        'items' => [
            ['label' => '<i class="material-icons">photo_library</i> ' . Yii::t('app', 'Galleries'), 'url' => ['/galleries/index']],
            ['label' => '<i class="material-icons">videocam</i> ' . Yii::t('app', 'Videos'), 'url' => ['/videos/index']],
            ['label' => '<i class="material-icons">star_rate</i> ' . Yii::t('app', 'Hall Of Fame'), 'url' => ['/halloffame/index']],

        ]
    ];
    $menuItems[] = ['label' => '<i class="material-icons">info</i> ' . Yii::t('app', 'Infos'),
        'items' => [
            ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
            ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
            ['label' => Yii::t('app', 'Journey'), 'url' => ['/location/index']],
            ['label' => Yii::t('app', 'Imprint'), 'url' => ['/site/imprint']]
        ]
    ];


    // display Signup and Login pages to guests of the site
    if (Yii::$app->user->isGuest) {

        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } // display Logout to all logged in users
    else  {
        if(Yii::$app->user->can('admin')) {
            $menuItems[] = [
                'label' => '<i class="material-icons">account_circle</i> ' . Yii::$app->user->identity->username,
                'items' => [
                    ['label' => '<i class="material-icons">settings</i> Backend', 'url' => ['/backend']],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('app', 'User Settings'), 'url' => ['/backend/user/update', 'id' => Yii::$app->user->id]],
                    ['label' => Yii::t('app', 'Players'), 'url' => ['/player/own-index']],
                    ['label' => Yii::t('app', 'Teams'), 'url' => ['/team/index']],
                    ['label' => Yii::t('app', 'Organisations'), 'url' => ['/organisation/index']],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                ]
            ];

        } else if (Yii::$app->user->can('premium')){
            $menuItems[] = [
                'label' => '<i class="material-icons">account_circle</i> ' . Yii::$app->user->identity->username,
                'items' => [
                    ['label' => Yii::t('app', 'User Settings'), 'url' => ['/backend/user/update', 'id' => Yii::$app->user->id]],
                    ['label' => Yii::t('app', 'Players'), 'url' => ['/player/own-index']],
                    ['label' => Yii::t('app', 'Teams'), 'url' => ['/team/index']],
                    ['label' => Yii::t('app', 'Organisations'), 'url' => ['/organisation/index']],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                ]
            ];
        } else {
            $menuItems[] = [
                'label' => '<i class="material-icons">account_circle</i> ' . Yii::$app->user->identity->username,
                'items' => [
                    ['label' => Yii::t('app', 'Settings'), 'url' => ['/backend/user/update', 'id' => Yii::$app->user->id]],
                    ['label' => Yii::t('app', 'Players'), 'url' => ['/player/own-index']],
                    ['label' => Yii::t('app', 'Teams'), 'url' => ['/team/index']],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                ]
            ];
        }
    }


    if (Yii::$app->user->can('admin')) {

    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">


        <ul class="navbar-nav nav navbar-left external-link-bar hidden-xs hidden-md">
            <li>
                <a href="https://www.facebook.com/BarCraftHL/" class="external-link"><i
                        class="fa fa-facebook-official" aria-hidden="true"></i></a>
            </li>
            <li>
                <a href="https://twitter.com/BarCraftHL" class="external-link"><i
                        class="fa fa-twitter-square" aria-hidden="true"></i></a>
            </li>
            <li>
                <a href="https://www.youtube.com/channel/UC6Hb-1s-cjpVVgBLvgijoRQ" class="external-link"><i
                        class="fa fa-youtube-square" aria-hidden="true"></i></a>
            </li>
            <li>
                <a href="http://twitch.tv/barcrafthl" class="external-link"><i
                        class="fa fa-twitch" aria-hidden="true"></i></a>
            </li>
            <li>
                <a href="http://bchl.challonge.com/" class="external-link">
                    <img src="<?= Url::to('@web/images/constant/icons/challonge.png') ?>">
                    </img>
                </a>
            </li>
            <li>
                <a href="http://wiki.teamliquid.net/hearthstone/Dorfkrug_Cup" class="external-link">
                    <img src="<?= Url::to('@web/images/constant/icons/liquidpedias.png') ?>">
                    </img>
                    </object>
                </a>
            </li>
        </ul>
        <div class="pull-right" style="padding: 1em">
            &copy;<a href="<?= Url::to("@web") ?>"> <?= Yii::t('app', Yii::$app->name) ?>      </a><?= date('Y') ?></br>
            <?= Html::a(Yii::t('app', 'Imprint'),Url::to('@web/site/imprint'))?>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
