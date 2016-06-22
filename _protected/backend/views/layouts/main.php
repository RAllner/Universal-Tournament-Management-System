<?php
use backend\assets\AppAsset;
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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= Url::to("@web/images/favicon/apple-touch-icon-57x57.png")?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= Url::to("@web/images/favicon/apple-touch-icon-60x60.png")?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= Url::to("@web/images/favicon/apple-touch-icon-72x72.png")?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= Url::to("@web/images/favicon/apple-touch-icon-76x76.png")?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= Url::to("@web/images/favicon/apple-touch-icon-114x114.png")?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= Url::to("@web/images/favicon/apple-touch-icon-120x120.png")?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= Url::to("@web/images/favicon/apple-touch-icon-144x144.png")?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= Url::to("@web/images/favicon/apple-touch-icon-152x152.png")?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::to("@web/images/favicon/apple-touch-icon-180x180.png")?>">
    <link rel="icon" type="image/png" href="<?= Url::to("@web/images/favicon/favicon-32x32.png")?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= Url::to("@web/images/favicon/android-chrome-192x192.png")?>" sizes="192x192">
    <link rel="icon" type="image/png" href="<?= Url::to("@web/images/favicon/favicon-96x96.png")?>" sizes="96x96">
    <link rel="icon" type="image/png" href="<?= Url::to("@web/images/favicon/favicon-16x16.png")?>" sizes="16x16">
    <link rel="manifest" href="<?= Url::to("@web/images/favicon/manifest.json")?>">
    <link rel="mask-icon" href="<?= Url::to("@web/images/favicon/safari-pinned-tab.svg")?>" color="#031d24">
    <link rel="shortcut icon" href="<?= Url::to("@web/images/favicon/favicon.ico")?>">
    <meta name="apple-mobile-web-app-title" content="BarCraft HL">
    <meta name="application-name" content="BarCraft HL"">
    <meta name="msapplication-TileColor" content="#181818">
    <meta name="msapplication-TileImage" content="<?= Url::to("@web/images/favicon/mstile-144x144.png")?>">
    <meta name="msapplication-config" content="<?= Url::to("@web/images/favicon/browserconfig.xml")?>">
    <meta name="theme-color" content="#ffffff">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        if (Yii::$app->user->can('admin')) {
            NavBar::begin([
                'brandLabel' => Yii::t('app', Yii::$app->name) . " Admin",
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);
        } else {
            NavBar::begin([
                'brandLabel' => Yii::t('app', Yii::$app->name) . " Settings",
                'brandUrl' => '../../site/index',
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);
        }
            // display Account and Users to admin+ roles
            if (Yii::$app->user->can('admin'))
            {
                $menuItems[] = ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/site/index']];
                $menuItems[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];
            }
            
            // display Login page to guests of the site
            if (Yii::$app->user->isGuest) 
            {
                $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            }
            // display Logout to all logged in users
            else 
            {
                $menuItems[] = ['label' => Yii::t('app', 'Back'), 'url' => ['../site/index', 'id' => Yii::$app->user->id]];

            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
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
        <p class="pull-left">&copy; <?= Yii::t('app', Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
