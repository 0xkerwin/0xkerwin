<?php
/**
 * Created by PhpStorm.
 * User: Kerwin
 * Date: 2017/3/18
 * Time: 19:12
 */

namespace backend\assets;

use yii\web\AssetBundle;


class CommonAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/default-list.css',
    ];
}