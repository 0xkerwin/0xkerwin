<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\assets\CommonAsset;
use backend\assets\JqueryAsset;

CommonAsset::register($this);
JqueryAsset::register($this);
?>

<style type="text/css">
     #picture, #delete-picture {
        font-size: 30px
    }
    
    #category-image_url {
        display: none;
    }
    
    #image-preview img
    {  
        width: 200px;
        height: 200px;
        border: 1px solid #aaa;
    } 
</style>

<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>    

    <?= $form->field($model, 'image_url')->fileInput(['maxlength' => true])->label() ?>

    <div class="form-group field-category-picture">
        <!-- <label class="control-label" for="category-picture">图片</label> -->
        <div class="upload-picture">

            <?php if($image_url): ?>

            <div class="text-center">
                <div id="image-preview" class=""><img src="<?= \Yii::$app->params['staticDomain'].$image_url ?>"></div>
                <span id="delete-picture" class="fa fa-trash"></span>
            </div>
            <span id="picture" class="fa fa-plus-square hide"></span>

            <?php else: ?>

            <div class="text-center">
                <div id="image-preview" class="hide"></div>
                <span id="delete-picture" class="fa fa-trash hide"></span>
            </div>
            <span id="picture" class="fa fa-plus-square"></span>

            <?php endif; ?>

        </div>
    </div>

    <div class="box-footer text-right" id="submitFrom">
        <?= Html::submitButton($model->isNewRecord ? '保存' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">

    $("#picture").click(function(){
        $("#category-image_url").click();
    });

    $("#delete-picture").click(function() {
        $("#delete-picture").addClass('hide');
        $("#image-preview").addClass('hide');
        $("#image-preview img").remove();
        $("#category-image_url").val('');
        $("#picture").removeClass('hide');
    });

    $(".field-category-image_url").on("change","input[type='file']",function(){

        var prevDiv = document.getElementById('image-preview'); 

        if (this.files && this.files[0])  
        {
            var reader = new FileReader();  
            reader.onload = function(evt){  
                $('#image-preview').html('<img src="' + evt.target.result + '" />');  
            }    
            reader.readAsDataURL(this.files[0]);
            $("#image-preview").removeClass('hide');
            $("#picture").addClass('hide');
            $("#delete-picture").removeClass('hide');
        }  
        else    
        {
            $("#image-preview").addClass('hide');
            $("#picture").removeClass('hide');
            $("#delete-picture").addClass('hide');
            $('#image-preview').html('<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + this.value + '\'"></div>');  
        }
    });

</script>

<!-- <div class="box-body">

    <?php //$form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-category-picture">
        <label class="control-label" for="category-picture">图片</label>
        <div class="upload-picture">
            <div class="text-center">
                <div id="image-preview" class="hide"></div>
                <span id="delete-picture" class="fa fa-trash hide"></span>
            </div>
            <span id="picture" class="fa fa-plus-square"></span>
        </div>
    </div>

    <?//= $form->field($model, 'image_url')->fileInput(['maxlength' => true])->label(false) ?>

    <div class="box-footer text-right">
        <?//= Html::submitButton($model->isNewRecord ? '保存' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php //ActiveForm::end(); ?>

</div>

<script type="text/javascript">

    $("#picture").click(function(){
        $("#category-image_url").click();
    });

    $("#delete-picture").click(function() {
        $("#delete-picture").addClass('hide');
        $("#image-preview").addClass('hide');
        $("#image-preview img").remove();
        $("#category-image_url").val('');
        $("#picture").removeClass('hide');
    });

    $(".field-category-image_url").on("change","input[type='file']",function(){

        var prevDiv = document.getElementById('image-preview'); 

        if (this.files && this.files[0])  
        {
            var reader = new FileReader();  
            reader.onload = function(evt){  
                $('#image-preview').html('<img src="' + evt.target.result + '" />');  
            }    
            reader.readAsDataURL(this.files[0]);
            $("#image-preview").removeClass('hide');
            $("#picture").addClass('hide');
            $("#delete-picture").removeClass('hide');
        }  
        else    
        {
            $("#image-preview").addClass('hide');
            $("#picture").removeClass('hide');
            $("#delete-picture").addClass('hide');
            $('#image-preview').html('<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + this.value + '\'"></div>');  
        }
    });

</script> -->