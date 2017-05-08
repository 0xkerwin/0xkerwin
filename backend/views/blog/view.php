<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Markdown;

$this->title = '博客详情';
$this->params['breadcrumbs'][] = ['label' => '博客列表', 'url' => ['index'] ];
$this->params['breadcrumbs'][] = $this->title;
$tags = explode(',', $tags);
?>
<style type="text/css">
.tags-label {
    border: 1px solid #d9d9d9;
    background-color: #ededed;
    margin: -1px 5px 5px 0;
    display: inline-block;
    padding: 0 4px 0 4px;
    vertical-align: top;
    color: #444;
}
.pitch-blank {
    margin:0 2px 0 2px;
}
</style>
<section class="content">

<!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                <h2><i class="fa fa-file-word-o"></i> <?= $model->title; ?></h2>
            </div>

            <div class="box-tools pull-right">
                <span class="text-muted pitch-blank"><i class="fa fa-user" data-widget="作者" data-toggle="tooltip" title="作者"></i> <?= $model->author->username?></span>
                <span class="text-muted pitch-blank"> <i class="fa fa-clock-o" data-widget="创建时间" data-toggle="tooltip" title="创建时间"></i> <?= $model->create_time?></span>
            </div>
            <div class="row">
                <div class="col-xs-12 text-right">
                    <span class="pitch-blank"><i class="fa fa-folder" data-widget="分类" data-toggle="tooltip" title="分类"></i> <?= $category?></span>
                    <span class=" pitch-blank"><i class="fa fa-tags" data-widget="标签" data-toggle="tooltip" title="标签"></i> 
                    <?php 
                        foreach ($tags as $key => $value) {
                            echo "<a class='tags-label'>".$value."</a>";
                        }
                     ?>
                     </span>
                </div>
            </div>
        </div>
        <div class="box-body">
            <?= Markdown::process($model->content, 'gfm') ?>
        </div>
    <!-- /.box-body -->
        <div class="box-footer text-right">
            <a class="btn btn-primary" href="<?= Url::to(['update', 'id'=>$model->id])?>">修改</a>
        </div>
    <!-- /.box-footer-->
    </div>
<!-- /.box -->

</section>