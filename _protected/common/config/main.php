<?php
return [
    'name' => 'BarCraft HL',
    'language' => 'de',
    'bootstrap' => ['languagepicker'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            'languages' => ['de', 'en'],         // List of available languages (icons only)
            'cookieName' => 'language',                         // Name of the cookie.
            'expireDays' => 64,                                 // The expiration time of the cookie is 64 days.
            'callback' => function() {
                if (!\Yii::$app->user->isGuest) {
                    $user = \Yii::$app->user->identity;
                    $user->language = \Yii::$app->language;
                    $user->save();
                }
            }
        ],
        'assetManager' => [
            'bundles' => [
                // we will use bootstrap css from our theme
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [], // do not use yii default one
                ],
                // // use bootstrap js from CDN
                // 'yii\bootstrap\BootstrapPluginAsset' => [
                //     'sourcePath' => null,   // do not use file from our server
                //     'js' => [
                //         'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js']
                // ],
                // // use jquery from CDN
                // 'yii\web\JqueryAsset' => [
                //     'sourcePath' => null,   // do not use file from our server
                //     'js' => [
                //         'ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
                //     ]
                // ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
    ], // components

    // set allias for our uploads folder so it can be shared by both frontend and backend applications
    // @appRoot alias is definded in common/config/bootstrap.php file
    'aliases' => [
        '@uploads' => '@appRoot/uploads',
        '@images' => '@appRoot/images'
    ],
];
