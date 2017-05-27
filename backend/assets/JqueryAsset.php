<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Jquery前端资源包
 *
 */
class JqueryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/jquery-1.10.2.min.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}