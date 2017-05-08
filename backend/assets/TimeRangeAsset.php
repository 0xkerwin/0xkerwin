<?php
/**
 * Created by PhpStorm.
 * User: Kerwin
 * Date: 2017/5/8
 * Time: 17:43
 */

namespace backend\assets;

use yii\web\AssetBundle;


class TimeRangeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/daterangepicker.min.css',
    ];
    public $js = [
        'js/moment.min.js',
        'js/daterangepicker.min.js',
        'js/daterangepicker.zh-cn.js',
        'js/range-time.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}