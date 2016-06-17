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


            if (!Yii::$app->user->can('editor')) 
            {

            }

            // display  to editor+ roles
            if (Yii::$app->user->can('editor'))
            {

            }
            if (Yii::$app->user->can('admin'))
            {
                $menuItems[] = ['label' => '<i class="material-icons">settings</i> '.Yii::t('app', 'ADMIN'), 'url' => ['/backend']];
            }
            // display Signup and Login pages to guests of the site
            if (Yii::$app->user->isGuest) 
            {
                $menuItems[] = ['label' => '<i class="material-icons">chrome_reader_mode</i> '.Yii::t('app', 'News'), 'url' => ['/article/index']];
                $menuItems[] = ['label' => '<i class="material-icons">play_arrow</i> '.Yii::t('app', 'Media'),
                    'items' =>   [
                        ['label' => '<i class="material-icons">photo_library</i> '.Yii::t('app', 'Galleries'), 'url' => ['/galleries/index']],
                        ['label' => '<i class="material-icons">videocam</i> '.Yii::t('app', 'Videos'), 'url' => ['/videos/index']],
                        ['label' => '<i class="material-icons">star_rate</i> '.Yii::t('app', 'Hall Of Fame'), 'url' => ['/halloffame/index']],

                    ]
                ];
                $menuItems[] = ['label' => '<i class="material-icons">info</i> '.Yii::t('app', 'Infos'),
                    'items' =>   [
                        ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
                        ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                        ['label' => Yii::t('app', 'Journey'), 'url' => ['/site/journey']]
                    ]
                ];
                $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            }
            // display Logout to all logged in users
            else 
            {
                //$menuItems[] = ['label' => '<i class="material-icons">videogame_asset</i> '. Yii::t('app', 'Tournaments'), 'url' => ['/tournaments/admin']];
                $menuItems[] = ['label' => '<i class="material-icons">chrome_reader_mode</i> '.Yii::t('app', 'News'), 'url' => ['/article/index']];
                $menuItems[] = ['label' => '<i class="material-icons">play_arrow</i> '.Yii::t('app', 'Media'),
                    'items' =>   [
                        ['label' => '<i class="material-icons">photo_library</i> '.Yii::t('app', 'Galleries'), 'url' => ['/galleries/index']],
                        ['label' => '<i class="material-icons">videocam</i> '.Yii::t('app', 'Videos'), 'url' => ['/videos/index']],
                        ['label' => '<i class="material-icons">star_rate</i> '.Yii::t('app', 'Hall Of Fame'), 'url' => ['/halloffame/index']],

                    ]
                ];
                $menuItems[] = ['label' => '<i class="material-icons">info</i> '.Yii::t('app', 'Infos'),
                    'items' =>   [
                        ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
                        ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                        ['label' => Yii::t('app', 'Journey'), 'url' => ['/site/journey']]
                    ]
                ];
                $menuItems[] = [
                    'label' => '<i class="material-icons">account_circle</i> ' . Yii::$app->user->identity->username,
                    'items' =>   [

                        ['label' => Yii::t('app', 'Settings'), 'url' => ['/backend/user/view', 'id'=> Yii::$app->user->id]],
                        ['label' => Yii::t('app', 'Players'), 'url' => ['/players/own-index']],
                        '<li class="divider"></li>',
                        ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],

                    ]


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
