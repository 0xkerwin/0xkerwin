<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Markdown;
use frontend\assets\HomeAsset;

HomeAsset::register($this);

$this->title = 'Kerwin';
?>
<style>
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="slide-show">
            <!-- main-slider -->
            <ul id="demo1">
                <li>
                    <img src="images/1.jpg" alt="" />
                    <!--Slider Description example-->
                    <div class="slide-desc">
                        <h3>Fashion</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's dummy. </p>
                    </div>
                </li>
                <li>
                    <img src="images/2.jpg" alt="" />
                    <div class="slide-desc">
                        <h3>Life Style </h3>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>
                    </div>
                </li>
                <li>
                    <img src="images/3.jpg" alt="" />
                    <div class="slide-desc">
                        <h3>Photography</h3>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature. </p>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-9">
        <div class="panel box-common">
            <div class="box-title">
                <span>最新文章</span>
                <span class="pull-right"><a href="<?= Url::to(['/blog'])?>" class="more">更多»</a></span>
            </div>
            <div class="new-list">
                <?php if(!empty($data)): foreach ($data as $key => $value):?>
                    <div class="panel-body border-bottom">
                        <div class="row">
                            <div class="col-lg-4 label-img-size">
                                <a href="<?= Url::to(['blog/view', 'id'=>$value->id])?>" class="post-label">
                                    <img src="<?= $value->categoryInfo->image_url ?>" alt="<?= $value->title ?>">
                                </a>
                            </div>
                            <div class="col-lg-8 btn-group">
                                <div class="col-lg-12">
                                    <h3>
                                        <a href="<?= Url::to(['blog/view', 'id'=>$value->id])?>">
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
                                <div class="col-lg-8">
                                    <div class="category pull-left">
                                        <span class="fa fa-folder"></span>
                                        <a href="#"><?= $value->categoryInfo->name?></a>
                                    </div>
                                    <div class="tags pull-left">
                                        <span class="fa fa-tags"></span>

                                        <?php
                                        if (isset($value->tags)):
                                            foreach (explode(',', $value->tags) as $k => $v):
                                                if (isset($tags[$v])):
                                                    echo '<a href="#" class="label label-warning tags-space">'.$tags[$v].'</a>';
                                                endif;
                                            endforeach;
                                        endif;
                                        ?>

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <a href="<?= Url::to(['blog/view', 'id'=>$value->id])?>"><button class="btn btn-warning no-radius btn-sm pull-right">阅读全文</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif;?>
                <div class="panel-body text-center">
                    <a href="<?= Url::to(['/blog'])?>"><button class="btn btn-warning no-radius">更多文章</button></a>
                </div>
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


<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});

        jQuery('#responsive').change(function(){
            $('#responsive_wrapper').width(jQuery(this).val());
        });

    });
</script>