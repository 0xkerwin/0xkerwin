<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class HomeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        // 'css/style.css',
        // 'css/flexslider.css',
        'css/skdslider.css',
        // 'css/googleapis.font.css',
    ];
    public $js = [
        // 'js/main.js',
        // 'js/jquery.flexslider.js',
        'js/skdslider.min.js',
        // 'js/move-top.js',
        // 'js/easing.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
