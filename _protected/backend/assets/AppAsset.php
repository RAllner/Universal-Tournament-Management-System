<?php
/**
 * -----------------------------------------------------------------------------
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * -----------------------------------------------------------------------------
 */

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

// set @themes alias so we do not have to update baseUrl every time we change themes
Yii::setAlias('@themes', Yii::$app->view->theme->baseUrl);

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 * @since 2.0
 *
 * Customized by Nenad Živković
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@themes';
    
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'frontend\assets\MaterialCSSAsset',
        'frontend\assets\MaterialJSAsset',
        'hiqdev\assets\lightbox2\LightboxAsset',
        'yii\materialicons\AssetBundle',
        'rmrevin\yii\fontawesome\AssetBundle'
    ];
}
