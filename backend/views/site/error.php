<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="row">
    <div class="col-md-12">
        <!--notification start-->
        <section class="panel">
            <header class="panel-heading">
               <h2><?= Html::encode($this->title) ?></h2>
            </header>
            <div class="panel-body">
                <div class="alert alert-error">
                    <h4>
                        <?= nl2br(Html::encode($message)) ?>
                    </h4>
                </div>
                <div class="pull-right">
                    <i class="fa fa-hand-o-right"></i>
                    <a href="<?= Url::to(['index'])?>">&nbsp;返回首页</a>
                </div>
            </div>
        </section>
        <!--notification end-->
    </div>
</div>
