<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\CommonAsset;
use backend\assets\TimeRangeAsset;

CommonAsset::register($this);
TimeRangeAsset::register($this);

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
$params_str = (new \yii\web\Request)->getQueryParams();
?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title"><i class="fa fa-user"></i>  <?= $this->title ?></h2>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="row">
                            <div class="col-xs-12">
                                <form id="search-form" class="form-inline" action="<?= Url::to('index')?>" method="get">
                                    <div class="form-group">
                                        <label><?=$attrbutes['created_at']; ?>：</label>
                                        <input type="text" class="form-control" id="" name="time_range" readonly="" value="<?= isset($params_str['time_range']) ? $params_str['time_range'] : ''?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?=$attrbutes['username']; ?>：</label>
                                        <input type="text" class="form-control" name="username" value="<?= isset($params_str['username']) ? $params_str['username'] : ''?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?=$attrbutes['email']; ?>：</label>
                                        <input type="text" class="form-control" name="email" value="<?= isset($params_str['email']) ? $params_str['email'] : ''?>">
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
                                    <a class="btn btn-sm btn-primary" href="<?= Url::to(['user-backend/create']) ?>" role="button"><i class="fa fa-plus"></i> 添加用户</a>
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
                                            <th><?=$attrbutes['username']; ?></th>
                                            <th><?=$attrbutes['email']; ?></th>
                                            <th><?=$attrbutes['created_at']; ?></th>
                                            <th><?=$attrbutes['updated_at']; ?></th>
                                            <th>操作</th>
                                        </tr>
                                        <?php foreach($datas as $key => $value): ?>
                                            <tr>
                                                <td>
                                                    <?=Html::encode($value['username']); ?>
                                                </td>

                                                <td>
                                                    <?=Html::encode(empty($value['email']) ? "—":$value['email']); ?>

                                                </td>
                                                <td>
                                                    <?=Html::encode($value['created_at']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['updated_at']); ?>
                                                </td>

                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <?php
                                                            if (\Yii::$app->user->getId()==\Yii::$app->params['adminId']){
                                                        ?>
                                                                <a href="<?=Url::to(['user-backend/update','id' => $value['id']]); ?>" data-widget="编辑" data-toggle="tooltip" title="编辑"><span class="fa fa-edit"></span></a>&nbsp;
                                                                <a href="<?=Url::to(['user-backend/change-pwd','id' => $value['id']]); ?>" data-widget="修改密码" data-toggle="tooltip" title="修改密码"><span class="fa fa-lock"></span></a>&nbsp;
                                                        <?php   if ($value['id']!=\Yii::$app->params['adminId']){ ?>
                                                                    <a onclick="delcfm(<?='\''.$value['id'].'\'';?>)" data-widget="删除" data-toggle="tooltip" title="删除"><span class="fa fa-trash"></span></a>
                                                        <?php   }
                                                            }else if($value['id']!=\Yii::$app->params['adminId']){
                                                        ?>
                                                                <a href="<?=Url::to(['user-backend/update','id' => $value['id']]); ?>" data-widget="编辑" data-toggle="tooltip" title="编辑"><span class="fa fa-edit"></span></a>&nbsp;
                                                                <a href="<?=Url::to(['user-backend/change-pwd','id' => $value['id']]); ?>" data-widget="修改密码" data-toggle="tooltip" title="修改密码"><span class="fa fa-lock"></span></a>&nbsp;
                                                        <?php
                                                            }
                                                        ?>
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

                        <!-- row start -->
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

<div class="modal fade" id="delete-user">
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
                <input type="hidden" id="user-id"/>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a  onclick="execDelete()" class="btn btn-success" data-dismiss="modal">确定</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

    function delcfm(id) {
        $('#user-id').val(id);//给会话中的隐藏属性URL赋值
        $('#delete-user').modal();
    }

    function execDelete(){
        var id = $.trim($("#user-id").val());//获取会话中的隐藏属性URL
        window.location.href = "<?=Url::to(['delete']); ?>?id="+id;
    }
</script>
