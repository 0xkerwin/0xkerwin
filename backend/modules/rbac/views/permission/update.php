<?php 
use yii\helpers\Html;
$this->title = '权限更新';
$this->params['breadcrumbs'][] = ['label' => '权限列表', 'url' => ['index'] ];
$this->params['breadcrumbs'][] = $this->title;
 ?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-edit"></i> <?= Html::encode($this->title) ?></h2>
        </div>

        <?= $this->render('_form', [
            'model' => $model,
            'menu_item' => $menu_item,
            'menu_id' => $menu_id,
        ]) ?>

</section>