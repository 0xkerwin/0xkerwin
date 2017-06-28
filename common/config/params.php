<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    /*列表显示记录条数*/
    'pageSize' => 5,
    //资源访问地址，如共同的图片、js、css
    'staticDomain' => 'http://static.0xkerwin.com',
    //redis keys前缀
    'redisKeys' => [
        'views_article' => 'kerwin_views_article_',
        'visit' => 'kerwin_visit_',
    ],
];
