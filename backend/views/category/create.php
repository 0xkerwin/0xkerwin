<?php 
use yii\helpers\Html;
$this->title = '添加分类';
$this->params['breadcrumbs'][] = ['label' => '博客分类列表', 'url' => ['index'] ];
$this->params['breadcrumbs'][] = $this->title;
 ?>
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-plus"></i> <?= Html::encode($this->title) ?></h2>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
            'image_url' => $image_url
        ]) ?>

    </div>

</section>