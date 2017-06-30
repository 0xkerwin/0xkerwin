<?php
use \yii\helpers\Url;
use backend\assets\SiteAsset;
use backend\assets\TimeRangeAsset;

SiteAsset::register($this);
TimeRangeAsset::register($this);
$this->title = '首页';
 ?>
 <style type="text/css">
    .show-more-div {
        float: right;
        padding: 10px 20px 10px 20px;
        text-align: right;
        width: 100%;
    }
    
    .nav-tabs-custom {
        cursor: move; border: 1px solid #ddd
    }
 </style>


<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-tachometer"></i> <?= $this->title?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="content">
                                <!-- START PROGRESS BARS -->
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6">
                                        <div class="small-box bg-yellow">
                                            <div class="inner">
                                                <h3><?= $userCount?></h3>

                                                <p>总用户</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-users"></i>
                                            </div>
                                            <a href="<?= Url::to(['/rbac/user-backend'])?>" class="small-box-footer"> 用户管理 <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xs-6">
                                        <div class="small-box bg-aqua">
                                            <div class="inner">
                                                <h3><?= $blogCount?></h3>

                                                <p>博客总数</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-book"></i>
                                            </div>
                                            <a href="<?= Url::to(['/blog'])?>" class="small-box-footer"> 博客管理 <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-xs-6">
                                        <div class="small-box bg-green">
                                            <div class="inner">
                                                <h3><?= $visitCount?></h3>

                                                <p>今日访问人数</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <a href="#visit" class="small-box-footer"> 访问人数 <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.row --><!-- END PROGRESS BARS -->
                            </section>
                        </div>
                    </div>

                    <div class="row" id="visit">
                        <div class="col-xs-12">
                            <div class="nav-tabs-custom" style="">
                                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                                    <li>
                                        <a id="unique-visitor-chart" data-toggle="tab">独立访客</a>
                                    </li>
                                    <li class="active">
                                        <a id="page-views-chart" data-toggle="tab">访问量</a>
                                    </li>
                                    <li class="pull-left header"><h5><i class="fa fa-eye"></i> 访问量</h5></li>
                                </ul>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="input-group margin">
                                            <input type="text" class="form-control" id="" name="time_range" readonly="" data-format="YYYY/MM/DD">
                                            <span class="input-group-btn">
                                                <button id="search" type="button" class="btn btn-info btn-flat">搜索</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <!-- <div class="btn-group-vertical"> -->
                                        <div class="show-more-div">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info active" id="a_week">一周</button>
                                                <button type="button" class="btn btn-info" id="three_week">三周</button>
                                                <button type="button" class="btn btn-info" id="one_month">一个月</button>
                                                <button type="button" class="btn btn-info" id="three_month">三个月</button>
                                                <button type="button" class="btn btn-info" id="half_year">半年</button>
                                                <button type="button" class="btn btn-info" id="one_year">一年</button>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                </div>

                                <div class="tab-content no-padding">
                                    <div class="chart tab-pane active" style="position: relative; height: 300px;"><div id="chart" style="height: 300px"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-header with-border">
                                <h5 class="box-title"><i class="fa fa-info-circle"></i> 系统信息</h5>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                        <!-- <th style="width: 10px">#</th> -->
                                        <th style="width: 200px">名称</th>
                                        <th>信息</th>
                                        <th style="width: 200px">说明</th>
                                        </tr>
                                        <?php
                                            foreach($sysInfo as $info){
                                               echo '<tr>';
                                               echo '<td>'.$info['name'].'</td>';
                                               echo '<td>'.$info['value'].'</td>';
                                               echo '<td></td>';
                                               echo '</tr>';
                                           }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                  
                </div>
            </div>
          <!-- /.box -->
        </div>
        
        
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        
    </div>
    <!-- /.row (main row) -->

</section>
<!-- /.content -->