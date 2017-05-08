<?php
use \yii\helpers\Url;
$this->title = '首页';
 ?>
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
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h3>0</h3>

                                            <p>前一小时在线用户</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"> 邀请管理 <i class="fa fa-arrow-circle-right"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <!-- /.row --><!-- END PROGRESS BARS -->
                        </section>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
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