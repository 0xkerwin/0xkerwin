<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Markdown;
use backend\assets\CommonAsset;
use backend\assets\TimeRangeAsset;

CommonAsset::register($this);
TimeRangeAsset::register($this);

$this->title = '博客列表';
$this->params['breadcrumbs'][] = $this->title;
$params_str = (new \yii\web\Request)->getQueryParams();
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-list-alt"></i>  <?= $this->title ?></h2>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="row">
                            <div class="col-xs-12">
                                <form id="search-form" class="form-inline" action="<?= Url::to('index')?>" method="get">
                                    <div class="form-group">
                                        <label>标题:</label>
                                        <input type="text" class="form-control" name="title" value="<?= isset($params_str['title']) ? $params_str['title'] : ''?>">
                                    </div>
                                    <div class="form-group">
                                        <label>内容:</label>
                                        <input type="text" class="form-control" id="" name="content">
                                    </div>
                                    <div class="form-group">
                                        <label>作者:</label>
                                        <input type="text" class="form-control" id="" name="author">
                                    </div>
                                    <div class="form-group">
                                        <label>创建时间:</label>
                                        <input type="text" class="form-control" id="" name="time_range">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-search"></i> 搜索</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- row end search -->
                        <div class="row pull-right">
                            <div class="col-xs-12">
                                <div class="btn-list">
                                    <a class="btn btn-sm btn-primary" href="<?= Url::to(['blog/create']) ?>" role="button"><i class="fa fa-plus"></i> 添加博客</a>
                                </div>
                            </div>
                        </div>
                        <!-- row end btn -->
                        <!-- row start -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box-body table-responsive no-padding">

                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <th><?=$attrbutes['title']; ?></th>
                                            <th><?=$attrbutes['content']; ?></th>
                                            <th>作者</th>
                                            <th>修改者</th>
                                            <th><?=$attrbutes['create_time']; ?></th>
                                            <th><?=$attrbutes['update_time']; ?></th>
                                            <th>操作</th>
                                        </tr>
                                        <?php foreach($datas as $key => $value): ?>
                                            <tr>
                                                <td>
                                                    <?=Html::encode($value['title']); ?>
                                                </td>

                                                <td>
                                                    <?=Html::encode(\common\helpers\StringHelper::truncateMsg(strip_tags(Markdown::process($value['content'], 'gfm')), 50)); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['author']['username']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['mender']['username']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['create_time']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['update_time']); ?>
                                                </td>

                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?=Url::to(['blog/update','id' => $value['id']]); ?>" data-widget="编辑" data-toggle="tooltip" title="编辑"><span class="fa fa-edit"></span></a>&nbsp;
                                                        <a href="<?=Url::to(['blog/view','id' => $value['id']]); ?>" data-widget="查看" data-toggle="tooltip" title="查看"><span class="fa fa-eye"></span></a>&nbsp;
                                                        <a type="button" onclick="delcfm(<?='\''.$value['id'].'\'';?>)" data-widget="编辑" data-toggle="tooltip" title="删除"><span class="fa fa-trash"></span></a>
                                                    </div>


                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                        <!-- row end -->                        
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="col-sm-5">
                        <div class="dataTables_info badge" id="editable-sample_info">
                            显示记录 <?= $pagination->offset+1; ?> 到 <?= $pagination->offset+$pagination->limit; ?>条，共 <?= $pagination->totalCount; ?> 条记录
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_bootstrap pagination  pull-right">
                            <?=  \yii\widgets\LinkPager::widget([
                                'pagination' => $pagination,
                                'firstPageLabel' => "首页",
                                'lastPageLabel' => "末页",
                                // 'linkOptions' =>'ss'

                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<div class="modal fade" id="delete-blog">  
    <div class="modal-dialog">  
        <div class="modal-content message_align">  
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>  
                <h4 class="modal-title">提示信息</h4>  
            </div>  
            <div class="modal-body">  
                <p>您确认要删除吗？</p>  
            </div>  
            <div class="modal-footer">  
                <input type="hidden" id="blog-id"/>  
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>  
                <a  onclick="execDelete()" class="btn btn-success" data-dismiss="modal">确定</a>  
            </div>  
        </div><!-- /.modal-content -->  
    </div><!-- /.modal-dialog -->  
</div><!-- /.modal -->  
<!--删除crumb-->

<script type="text/javascript">
    function delcfm(id) {  
        $('#blog-id').val(id);//给会话中的隐藏属性URL赋值  
        $('#delete-blog').modal();  
    }  

    function execDelete(){  
        var id = $.trim($("#blog-id").val());//获取会话中的隐藏属性URL
        window.location.href = "<?=Url::to(['delete']); ?>?id="+id;
    }
</script>
