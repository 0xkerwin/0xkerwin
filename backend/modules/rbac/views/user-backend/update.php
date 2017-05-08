<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\SignupForm */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '修改用户';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-edit"></i> <?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-body">
            <?php $form = ActiveForm::begin(['id' => 'form-update']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?//= $form->field($model, 'password_hash')->passwordInput() ?>

            <?php if(isset($model->username) && $model->id!= \Yii::$app->params['adminId']){?>
                <div class="form-group">
                    <?php $role_model->item_name = $select_role ?>
                    <?= $form->field($role_model, 'item_name')->checkBoxList($roles, empty($select_role)? []:$select_role) ?>
                </div>
            <?php }else{ ?>
                <div class="form-group">
                    <?= $form->field($role_model, 'item_name')->label(false)->hiddenInput() ?>
                </div>
            <?php }?>

            <div class="box-footer text-right">
                <?= Html::submitButton('更新', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>