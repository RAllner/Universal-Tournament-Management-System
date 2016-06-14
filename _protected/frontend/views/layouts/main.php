<?php
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\helpers\Html;
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
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::t('app', Yii::$app->name),
                'brandUrl' => Yii::$app->homeUrl,

                'options' => [
                    'class' => 'navbar-nav navbar-fixed-top',

                ],
            ]);

            // everyone can see Home page
            $menuItems[] = ['label' => '<span class="glyphicon glyphicon-home"></span>', 'url' => ['/site/index']];

            // we do not need to display Article/index, About and Contact pages to editor+ roles
            if (!Yii::$app->user->can('editor')) 
            {
                $menuItems[] = ['label' => '<i class="material-icons">videogame_asset</i> '. Yii::t('app', 'Tournaments'), 'url' => ['/tournaments/index']];
                $menuItems[] = ['label' => '<i class="material-icons">chrome_reader_mode</i> '.Yii::t('app', 'News'), 'url' => ['/article/index']];
                $menuItems[] = ['label' => '<i class="material-icons">perm_media</i> '.Yii::t('app', 'Media'),
                    'items' =>   [
                        ['label' => Yii::t('app', 'Galleries'), 'url' => ['/galleries/index']],
                        ['label' => Yii::t('app', 'Videos'), 'url' => ['/videos/index']],

                    ]
                ];
                $menuItems[] = ['label' => Yii::t('app', 'Infos'),
                    'items' =>   [
                        ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
                        ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                        ['label' => Yii::t('app', 'Journey'), 'url' => ['/site/journey']]
                    ]
                ];

            }

            // display Article admin page to editor+ roles
            if (Yii::$app->user->can('editor'))
            {
                $menuItems[] = ['label' => '<i class="material-icons">videogame_asset</i> '. Yii::t('app', 'Tournaments'), 'url' => ['/tournaments/admin']];
                $menuItems[] = ['label' => '<i class="material-icons">chrome_reader_mode</i> '.Yii::t('app', 'News'), 'url' => ['/article/index']];
                $menuItems[] = ['label' => '<i class="material-icons">perm_media</i> '.Yii::t('app', 'Media'),
                    'items' =>   [
                        ['label' => Yii::t('app', 'Galleries'), 'url' => ['/galleries/index']],
                        ['label' => Yii::t('app', 'Videos'), 'url' => ['/videos/index']],

                    ]
                ];
            }
            if (Yii::$app->user->can('admin'))
            {
                $menuItems[] = ['label' => '<i class="material-icons">settings</i> '.Yii::t('app', 'ADMIN'), 'url' => ['/backend']];
            }
            // display Signup and Login pages to guests of the site
            if (Yii::$app->user->isGuest) 
            {
                $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            }
            // display Logout to all logged in users
            else 
            {
                $menuItems[] = [
                    'label' => '<i class="material-icons">account_circle</i> '.Yii::t('app', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
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
        <p class="pull-left">&copy; <?= Yii::t('app', Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
