<?php
return [
    'adminEmail' => 'admin@example.com',
    'admin.configs' => [
        'db' => 'db',
        'menuTable' => '{{%menu}}',
        'cache' => null,
        'cacheDuration' => 3600
    ],

    /*系统管理员ID*/
    'adminId' => 1,

    /*列表显示记录条数*/
    'pageSize' => 5,

    /*操作类型*/
    'operate_type' => [
        ['opt_search' => '查询'],
        ['opt_create' => '创建'],
        ['opt_delete' => '删除'],
        ['opt_opdate' => '修改'],
        ['opt_show' => '查看'],
        ['opt_export' => '导出'],
        ['opt_import' => '导入'],
        ['opt_login' => '登录'],
        ['opt_logout' => '登出'],
    ],

    /*针对访客和用户开放的操作权限*/
    'optAuth' => [
        'guest' => [
            'site/error',
            'site/logout',
            'site/login',
            'site/captcha',
        ],
        'user' => [
            'site/error',
            'site/index',
            'site/visit', //ajax获取访问人数
            'role/get-tree',//ajax获取角色列表
            'permission/get-tree',//ajax获取权限列表
            'site/logout',
            'site/login',
            'site/captcha',
            'file/upload',
            'debug/default/toolbar', //debug调试
        ],
    ],
];
