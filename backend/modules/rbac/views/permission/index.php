<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\CommonAsset;

CommonAsset::register($this);

$this->title = '权限列表';
$this->params['breadcrumbs'][] = $this->title;
$params_str = (new \yii\web\Request)->getQueryParams();
 ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">

                <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-lock"></i>  <?= $this->title ?></h2>
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
                                        <label><?=$attrbutes['description']; ?>：</label>
                                        <input type="text" class="form-control" name="description" value="<?= isset($params_str['description']) ? $params_str['description'] : ''?>">
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
                                    <a class="btn btn-sm btn-primary" href="<?= Url::to(['permission/create']) ?>" role="button"><i class="fa fa-plus"></i> 添加权限</a>
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
                                            <th><?=$attrbutes['name']; ?></th>
                                            <th><?=$attrbutes['description']; ?></th>
                                            <th><?=$attrbutes['rule_name']; ?></th>
                                            <th><?=$attrbutes['data']; ?></th>
                                            <th><?=$attrbutes['created_at']; ?></th>
                                            <th><?=$attrbutes['updated_at']; ?></th>
                                            <th>操作</th>
                                        </tr>

                                        <?php foreach($datas as $key => $item): ?>
                                            <tr>
                                                <td>
                                                    <?=Html::encode(empty($item['name']) ? "—":$item['name']); ?>
                                                </td>

                                                <td>
                                                    <?=Html::encode(empty($item['description']) ? "—":$item['description']); ?>

                                                </td>

                                                <td>
                                                    <?=Html::encode(empty($item['rule_name']) ? "—":$item['rule_name']); ?>
                                                </td>

                                                <td >
                                                    <?=Html::encode(empty($item['data']) ? "—":$item['data']); ?>
                                                </td>

                                                <td >
                                                    <?=Html::encode(empty($item['created_at']) ? "—":date('Y-m-d H:i:s', $item['created_at'])); ?>
                                                </td>

                                                <td >
                                                    <?=Html::encode(empty($item['updated_at']) ? "—":date('Y-m-d H:i:s', $item['updated_at'])); ?>
                                                </td>

                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?=Url::to(['permission/update','name' => $item['name']]); ?>" data-widget="编辑" data-toggle="tooltip" title="编辑"><span class="fa fa-edit"></span></a>&nbsp;
                                                        <a onclick="delcfm(<?='\''.$item['name'].'\'';?>)" data-widget="删除" data-toggle="tooltip" title="删除"><span class="fa fa-trash"></span></a>
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
                        <div class="dataTables_paginate paging_bootstrap pagination pull-right">
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

<div class="modal fade" id="delete-permission">
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
                <input type="hidden" id="permission-id"/>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a  onclick="execDelete()" class="btn btn-success" data-dismiss="modal">确定</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

    function delcfm(id) {
        $('#permission-id').val(id);//给会话中的隐藏属性URL赋值
        $('#delete-permission').modal();
    }

    function execDelete(){
        var name = $.trim($("#permission-id").val());//获取会话中的隐藏属性URL
        window.location.href = "<?=Url::to(['delete']); ?>?name="+name;
    }
</script>