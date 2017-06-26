<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '添加博客';
$this->params['breadcrumbs'][] = ['label' => '博客列表', 'url' => ['index'] ];
$this->params['breadcrumbs'][] = $this->title;


?>

<section class="content">

<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-pencil-square"></i> <?= Html::encode($this->title) ?></h2>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
            'category' => $category,
            'hot_tags' => $hot_tags,
        ]) ?>

    </div>
    
</section>
