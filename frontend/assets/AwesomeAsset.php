<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * awesome font 前端资源包
 *
 */
class AwesomeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'font-awesome-4.6.3/css/font-awesome.min.css',
    ];
}
