<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = '修改密码';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-lock  "></i> <?= Html::encode($this->title) ?></h2>
        </div>
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['disabled'=>'disabled'])?>

            <?= $form->field($change_pwd, 'password_hash')->passwordInput() ?>

            <?= $form->field($change_pwd, 'new_password')->passwordInput()?>

            <?= $form->field($change_pwd, 'verify_new_password')->passwordInput()?>

            <div class="box-footer text-right">
                <?= Html::submitButton($model->isNewRecord ? '保存' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</section>