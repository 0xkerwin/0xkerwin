<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '修改博客';
$this->params['breadcrumbs'][] = ['label' => '博客列表', 'url' => ['index'] ];
$this->params['breadcrumbs'][] = $this->title;

?>

<section class="content">

<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-edit"></i> <?= Html::encode($this->title) ?></h2>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
            'category' => $category
        ]) ?>

    </div>
    
</section>
