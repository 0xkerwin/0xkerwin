<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '博客列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="col-lg-12">
            <div class="panel box-common">
                <div class="new-list">
                    <?php if(!empty($data)): foreach ($data as $key => $value):?>
                        <div class="panel-body border-bottom">
                            <div class="row">
                                <div class="col-lg-4 label-img-size">
                                    <a href="<?= Url::to(['blog/view', 'id'=>$value->id])?>" class="post-label">
                                        <img src="<?= \Yii::$app->params['staticDomain'].$value->categoryInfo->image_url ?>" alt="<?= $value->title ?>">
                                    </a>
                                </div>
                                <div class="col-lg-8 btn-group">
                                    <div class="col-lg-12">
                                        <h3>
                                            <a href="<?= Url::to(['blog/view', 'id'=>$value->id])?>" class="title-font-color">
                                                <?= $value->title ?>
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="col-lg-12 text-right">
                                        <p class="post-tags">
                                            <span class="fa fa-user tags-space"> <a href="#"><?= $value->author->username ?></a></span>
                                            <span class="fa fa-clock-o tags-space"> <?= date('Y-m-d', strtotime($value->create_time)) ?></span>
                                            <span class="fa fa-eye tags-space"> 10000</span>
                                            <span class="fa fa-comment tags-space"> <a href="#">10</a></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-12">
                                        <p class="post-content">
                                            <?= Html::encode(\common\helpers\StringHelper::truncateMsg(strip_tags(Markdown::process($value['content'], 'gfm')), 150)); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- <div class="col-lg-8"> -->
                                        <div class="category pull-left">
                                            <span class="fa fa-folder"></span>
                                            <a href="<?= Url::to(['blog/index', 'category'=>$value->categoryInfo->id])?>" class="label"><?= $value->categoryInfo->name?></a>
                                        </div>
                                        <div class="tags pull-left">

                                            <?php
                                            if (isset($value->tags)):
                                                echo '<span class="fa fa-tags"></span>';
                                                foreach (explode(',', $value->tags) as $k => $v):
                                                    if (isset($tags[$v])):
                                                        echo '<a href="'.Url::to(["blog/index", "tag"=>$v]).'" class="label label-warning tags-space">'.$tags[$v].'</a>';
                                                    endif;
                                                endforeach;
                                            endif;
                                            ?>

                                        </div>
                                    <!-- </div> -->
                                    <!-- <div class="col-lg-4">
                                        <a href="<?//= Url::to(['blog/view', 'id'=>$value->id])?>"><button class="btn btn-warning no-radius btn-sm pull-right">阅读全文</button></a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    <?php endforeach; endif;?>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="dataTables_paginate paging_bootstrap pagination">
                <?=  \yii\widgets\LinkPager::widget([
                    'pagination' => $pagination,
                    'firstPageLabel' => "首页",
                    'lastPageLabel' => "末页",
                    // 'linkOptions' =>'ss'

                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <?= $this->render(
                '/layouts/right.php'
            )
        ?>
    </div>
</div>
