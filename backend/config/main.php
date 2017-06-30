<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'rbac' => 'backend\modules\rbac\Module',
    ],
    /*'modules' => [
        "admin" => [        
            "class" => "mdm\admin\Module",   
        ],
    ],*/
    /*"aliases" => [    
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],*/
    'components' => [
        'request' => [
            'csrfParam' => '_csrf',
            'cookieValidationKey' => 'BLQ3HoNMMQVwMSuwDbhGNhh1Emjdk5Qp',
        ],
        'user' => [
            'identityClass' => 'backend\modules\rbac\models\UserBackend',
            'enableAutoLogin' => false,
            'authTimeout' => 3600,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'timeout' => 3600,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /*路由美化*/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'suffix' => '',
            'rules' => [
                '<module:\w+>/<controller:\w+>/<id:\d+>' => '<module>/<controller>/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
            ],
        ],

        /*主题颜色*/
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
            ],
        ],

        /*rbac*/
        'authManager' => [        
            "class" => 'yii\rbac\DbManager', //这里记得用单引号而不是双引号        
            "defaultRoles" => ["guest"],
        ],
    ],

    /*权限控制*/
    'as access' => [
        'class' => 'backend\modules\rbac\components\AccessControl',
    ],

    'params' => $params,
    
    /*'on beforeRequest' => function($event) {
        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE, ['backend\components\syslog\SystemLog', 'write']);
    },*/
];
