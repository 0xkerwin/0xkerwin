<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\CommonAsset;

CommonAsset::register($this);

$this->title = '博客分类列表';
$this->params['breadcrumbs'][] = $this->title;
$params_str = (new \yii\web\Request)->getQueryParams();
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-file-text"></i>  <?= $this->title ?></h2>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="row">
                            <div class="col-xs-12">
                                <form id="search-form" class="form-inline" action="<?= Url::to('index')?>" method="get">
                                    <div class="form-group">
                                        <label><?=$attrbutes['name']; ?>：</label>
                                        <input type="text" class="form-control" name="name" value="<?= isset($params_str['name']) ? $params_str['name'] : ''?>">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-search"></i> 搜索</button>
                                        <button type="reset" class="btn btn-primary btn-sm"> <i class="fa fa-eraser"></i> 重置</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- row end search -->
                        <div class="row pull-right">
                            <div class="col-xs-12">
                                <div class="btn-list">
                                    <a class="btn btn-sm btn-primary" href="<?= Url::to(['create']) ?>" role="button"><i class="fa fa-plus"></i> 添加分类</a>
                                </div>
                            </div>
                        </div>
                        <!-- row start -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box-body table-responsive no-padding">

                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <th><?=$attrbutes['id']; ?></th>
                                            <th><?=$attrbutes['name']; ?></th>
                                            <th><?=$attrbutes['count']; ?></th>
                                            <th><?=$attrbutes['image_url']; ?></th>
                                            <th>操作</th>
                                        </tr>
                                        <?php foreach($datas as $key => $value): ?>
                                            <tr>
                                                <td>
                                                    <?=Html::encode($value['id']); ?>
                                                </td>

                                                <td>
                                                    <?=Html::encode($value['name']); ?>
                                                </td>

                                                <td>
                                                    <?=Html::encode($value['count']); ?>
                                                </td>

                                                <td>
                                                    <?=Html::encode($value['image_url']); ?>
                                                </td>

                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?=Url::to(['update','id' => $value['id']]); ?>" data-widget="编辑" data-toggle="tooltip" title="编辑"><span class="fa fa-edit"></span></a>&nbsp;
                                                        <a onclick="view(<?='\''.$value['id'].'\'';?>)" data-widget="查看" data-toggle="tooltip" title="查看"><span class="fa fa-eye"></span></a>&nbsp;
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

<div class="modal fade" id="delete-category">  
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
                <input type="hidden" id="category-id"/>  
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>  
                <a  onclick="execDelete()" class="btn btn-success" data-dismiss="modal">确定</a>  
            </div>  
        </div><!-- /.modal-content -->  
    </div><!-- /.modal-dialog -->  
</div><!-- /.modal -->  
<!--删除crumb-->

<div class="modal fade" id="category-view">  
    <div class="modal-dialog">  
        <div class="modal-content message_align">  
            <div class="modal-header">  
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>  
                <h4 class="modal-title">分类详情</h4>  
            </div>  
            <div class="modal-body">  
                
            </div>  
            <div class="modal-footer">
                <a class="btn btn-primary" data-dismiss="modal">修改</a>
            </div>  
        </div><!-- /.modal-content -->  
    </div><!-- /.modal-dialog -->  
</div><!-- /.modal -->  

<script type="text/javascript">
    function delcfm(id) {  
        $('#category-id').val(id);//给会话中的隐藏属性URL赋值  
        $('#delete-category').modal();  
    }  

    function execDelete(){  
        var id = $.trim($("#category-id").val());//获取会话中的隐藏属性URL
        window.location.href = "<?=Url::to(['delete']); ?>?id="+id;
    }

    function view(id){
        var url = "<?=Url::to(['view']); ?>?id="+id;
        var editUrl = "<?=Url::to(['update']); ?>?id="+id;
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(res){
                var staticDomain = "<?= \Yii::$app->params['staticDomain'] ?>";
                var htmlStr = '';
                htmlStr += '<div class="row">';
                htmlStr += '<div class="col-lg-2"><label>分类ID</label></div>';
                htmlStr += '<div class="col-lg-10">'+res.id+'</div>';
                htmlStr += '</div>';
                htmlStr += '<div class="row">';
                htmlStr += '<div class="col-lg-2"><label>分类名称</label></div>';
                htmlStr += '<div class="col-lg-10">'+res.name+'</div>';
                htmlStr += '</div>';
                htmlStr += '<div class="row">';
                htmlStr += '<div class="col-lg-2"><label>文章总数</label></div>';
                htmlStr += '<div class="col-lg-10">'+res.count+'</div>';
                htmlStr += '</div>';
                htmlStr += '<div class="row">';
                htmlStr += '<div class="col-lg-2"><label>创建时间</label></div>';
                htmlStr += '<div class="col-lg-10">'+res.create_time+'</div>';
                htmlStr += '</div>';
                htmlStr += '<div class="row">';
                htmlStr += '<div class="col-lg-2"><label>更新时间</label></div>';
                htmlStr += '<div class="col-lg-10">'+res.update_time+'</div>';
                htmlStr += '</div>';
                htmlStr += '<div class="row">';
                htmlStr += '<div class="col-lg-2"><label>图片</label></div>';
                htmlStr += '<div class="col-lg-6"><img style="width: 100%;border:1px solid #aaa;" src="'+staticDomain+res.image_url+'" ></div>';
                htmlStr += '</div>';
                $('#category-view .modal-body').html(htmlStr);
                $('#category-view').modal();
                $('.modal-footer a').click(function(){
                    window.location.href = editUrl;
                });
            }
        });
    }
</script>

