<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\JqueryAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use common\models\Visit;

Visit::Visit(); //统计访问量
AppAsset::register($this);
JqueryAsset::register($this);
$params_str = (new \yii\web\Request)->getQueryParams();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '0xkerwin',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
        ['label' => '博客', 'url' => ['/blog/index']],
        ['label' => '关于', 'url' => ['/site/about']],
        ['label' => '联系', 'url' => ['/site/contact']],
        '<li><form class="navbar-form" action="'.Url::to(['/blog/index']).'" method="get"><div class="input-group"><input type="text" class="form-control" name="search_keyword" placeholder="全站搜索" value="'.(isset($params_str['search_keyword']) ? $params_str['search_keyword'] : '').'"><span class="input-group-btn"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span></button></span></div></form><li>',
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<div class="backTop">
    <a href="#" class="toTop" style="display: inline;" data-widget="返回顶部" data-toggle="tooltip" title="返回顶部"><span class="toTopHover" style="opacity: 0;"></span></a>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <!-- <p class="pull-right"><?//= Yii::powered() ?></p> -->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
