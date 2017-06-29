<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\CommonAsset;
use backend\assets\TimeRangeAsset;

CommonAsset::register($this);
TimeRangeAsset::register($this);

$this->title = '操作日志列表';
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
                                        <label><?=$attrbutes['record_time']; ?>：</label>
                                        <input type="text" class="form-control" id="" name="time_range" readonly="" value="<?= isset($params_str['time_range']) ? $params_str['time_range'] : ''?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?=$attrbutes['admin_name']; ?>：</label>
                                        <input type="text" class="form-control" name="admin_name" value="<?= isset($params_str['admin_name']) ? $params_str['admin_name'] : ''?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?=$attrbutes['object']; ?>：</label>
                                        <input type="text" class="form-control" name="object" value="<?= isset($params_str['object']) ? $params_str['object'] : ''?>">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-search"></i> 搜索</button>
                                        <button type="reset" class="btn btn-primary btn-sm"> <i class="fa fa-eraser"></i> 重置</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- row end search -->
                        <!-- row start -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box-body table-responsive no-padding">

                                    <table class="table table-hover">
                                        <tbody>
                                        <tr>
                                            <th><?=$attrbutes['id']; ?></th>
                                            <th><?=$attrbutes['admin_id']; ?></th>
                                            <th><?=$attrbutes['admin_name']; ?></th>
                                            <th><?=$attrbutes['admin_ip']; ?></th>
                                            <th><?=$attrbutes['route']; ?></th>
                                            <th><?=$attrbutes['model']; ?></th>
                                            <th><?=$attrbutes['object']; ?></th>
                                            <th><?=$attrbutes['type']; ?></th>
                                            <th><?=$attrbutes['description']; ?></th>
                                            <th><?=$attrbutes['result']; ?></th>
                                            <th><?=$attrbutes['record_time']; ?></th>
                                        </tr>
                                        <?php foreach($datas as $key => $value): ?>
                                            <tr>
                                                <td>
                                                    <?=Html::encode($value['id']); ?>
                                                </td>

                                                <td>
                                                    <?=Html::encode($value['admin_id']); ?>

                                                </td>
                                                <td>
                                                    <?=Html::encode($value['admin_name']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['admin_ip']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['route']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['model']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['object']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($adminLog->operateType($value['type'], 'value')); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['description']); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode($value['result']==1 ? ' 成功' : '失败'); ?>
                                                </td>
                                                <td>
                                                    <?=Html::encode(date('Y-m-d H:i:s', $value['record_time'])); ?>
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
