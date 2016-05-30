<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap material css files.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class  MaterialJSAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-material-design/dist';
    public $js = [
        'js/ripples.min.js',
        'js/material.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
