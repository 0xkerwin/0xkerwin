<?php 
use yii\helpers\Html;
$this->title = '角色更新';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index'] ];
$this->params['breadcrumbs'][] = $this->title;
 ?>
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-edit"></i> <?= Html::encode($this->title) ?></h2>
        </div>

        <?= $this->render('_form', [
            'model' => $model
        ]) ?>

    </div>

</section>