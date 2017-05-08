<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\CommonAsset;

CommonAsset::register($this);

$this->title = '菜单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">

                <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-th-list"></i>  <?= $this->title ?></h2>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="row">
                            <div class="col-xs-12">
                                <form id="search-form" class="form-inline" action="" method="get">
                                    <div class="form-group">
                                        <label>ID:</label>
                                        <input type="text" class="form-control" id="" name="" value="">
                                    </div>
                                    <div class="form-group">
                                        <a class="btn btn-primary btn-sm" href="#"> <i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- row end search -->
                        <div class="row pull-right">
                            <div class="col-xs-12">
                                <div class="btn-list">
                                    <a class="btn btn-sm btn-primary" href="<?= Url::to(['menu/create']) ?>" role="button"><i class="fa fa-plus"></i> 添加菜单</a>
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
                                                <th><?=$attrbutes['id']; ?></th>
                                                <th><?=$attrbutes['name']; ?></th>
                                                <th><?=$attrbutes['parent']; ?></th>
                                                <th><?=$attrbutes['route']; ?></th>
                                                <th><?=$attrbutes['order']; ?></th>
                                                <th><?=$attrbutes['data']; ?></th>
                                                <th>操作</th>
                                            </tr>

                                            <?php foreach($datas as $key => $item): ?>
                                                <tr>
                                                    <td>
                                                        <?=Html::encode($item['id']); ?>
                                                    </td>

                                                    <td>
                                                        <?=Html::encode($item['name']); ?>

                                                    </td>
                                                    <td>
                                                        <?=Html::encode(empty($item['parent']) ? "—":$item['parent']); ?>
                                                    </td>


                                                    <td >
                                                        <?=Html::encode(empty($item['route']) ? "—":$item['route']); ?>
                                                    </td>

                                                    <td >
                                                        <?=Html::encode(empty($item['order']) ? "—":$item['order']); ?>
                                                    </td>

                                                    <td >
                                                        <?=Html::encode(empty($item['data']) ? "—":$item['data']); ?>
                                                    </td>

                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?=Url::to(['menu/update','id' => $item['id']]); ?>" data-widget="编辑" data-toggle="tooltip" title="编辑"><span class="fa fa-edit"></span></a>&nbsp;
                                                            <a onclick="delcfm(<?='\''.$item['id'].'\'';?>)" data-widget="删除" data-toggle="tooltip" title="删除"><span class="fa fa-trash"></span></a>
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
                            显示记录 <?= $pagination->offset+1; ?> 到 <?= $pagination->offset+$pagination->limit; ?>，共 <?= $pagination->totalCount; ?> 条记录
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_bootstrap pagination  pull-right">
                            <?=  \yii\widgets\LinkPager::widget([
                                'pagination' => $pagination,
                                'firstPageLabel' => "首页",
                                'lastPageLabel' => "末页",
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

<!--删除crumb-->
<div class="modal fade" id="delete-menu">  
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
                <input type="hidden" id="menu-id"/>  
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>  
                <a  onclick="execDelete()" class="btn btn-success" data-dismiss="modal">确定</a>  
            </div>  
        </div><!-- /.modal-content -->  
    </div><!-- /.modal-dialog -->  
</div><!-- /.modal -->  

<script type="text/javascript">
    
    function delcfm(id) {  
        $('#menu-id').val(id);//给会话中的隐藏属性URL赋值  
        $('#delete-menu').modal();  
    }  

    function execDelete(){  
        var id = $.trim($("#menu-id").val());//获取会话中的隐藏属性URL
        window.location.href = "<?=Url::to(['delete']); ?>?id="+id;
    }  
</script>
