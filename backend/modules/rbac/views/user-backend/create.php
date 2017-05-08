<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\CreateForm */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '添加用户';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-plus"></i> <?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-body">
            <?php $form = ActiveForm::begin(['id' => 'form-update']); ?>

            <?= $form->field($model, 'username')->label('用户名')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password_hash')->label('密码')->passwordInput() ?>

            <?= $form->field($model, 'verify_password')->label('确认密码')->passwordInput() ?>

            <?= $form->field($model, 'role')->label('角色')->checkboxList($role) ?>

            <div class="box-footer text-right">
                <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>