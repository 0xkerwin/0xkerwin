<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\assets\CommonAsset;
use backend\assets\JqueryAsset;

CommonAsset::register($this);
JqueryAsset::register($this);

$this->title = '分类更新';
$this->params['breadcrumbs'][] = ['label' => '博客分类列表', 'url' => ['index'] ];
$this->params['breadcrumbs'][] = $this->title;
 ?>

<style type="text/css">
     #picture, #delete-picture {
        font-size: 30px
    }
    
    #category-file {
        display: none;
    }
    
    #image-preview img
    {  
        width: 200px;
        height: 200px;
        border: 1px solid #aaa;
    } 
</style>

<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title"><i class="fa fa-edit"></i> <?= Html::encode($this->title) ?></h2>
        </div>        

        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>    

            <?= $form->field($model, 'image_url')->hiddenInput(['maxlength' => true])->label() ?>

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

            <?= $form->field($model, 'file')->fileInput(['maxlength' => true])->label(false) ?>

            <div class="box-footer text-right" id="submitFrom">
                <?= Html::submitButton('更新', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</section>

<script type="text/javascript">

    $("#picture").click(function(){
        $("#category-file").click();
    });

    $("#delete-picture").click(function() {
        $("#delete-picture").addClass('hide');
        $("#image-preview").addClass('hide');
        $("#image-preview img").remove();
        $("#category-file").val('');
        $("#picture").removeClass('hide');
        $("#category-image_url").val('');
    });

    $(".field-category-file").on("change","input[type='file']",function(){

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