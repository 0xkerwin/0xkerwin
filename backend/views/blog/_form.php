<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yiier\editor\EditorMdWidget;
use backend\assets\BlogAsset;

BlogAsset::register($this);

?>

<style type="text/css">

    ul.tag {
        margin-top: 2em;
    }
    ul.tag li {
        display: inline-block;
        margin-top: 6px;
        margin-right: 3px;
    }
    ul.tag li a {
        display: inline-block;
        padding: 7px 13px 5px;
        font-size: 14px;
        color: #999;
        border: 1px solid #cecece;
        letter-spacing: 0.1em;
        text-decoration: none;
    }
    ul.tag li a:hover{
        background:#337ab7;
        color:#fff;
    }
    ul{
        margin:0;
        padding:0;
    }
</style>
<div class="box-body">
    <?php $form = ActiveForm::begin(['options' => ['onkeydown' => 'if(event.keyCode==13){return false;}']]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->dropDownList($category, ['prompt'=>'请选择']) ?>
    
    <?= $form->field($model, 'content')->widget(EditorMdWidget::className(), [
            'options' => [
                'height' => '640',
//                'previewTheme' => 'dark',
//                'editorTheme' => 'pastel-on-dark',
                'markdown' => '',
                'codeFold' => true,
                'syncScrolling' => true,
                'saveHTMLToTextarea' => true,    // 保存 HTML 到 Textarea
                'searchReplace' => true,
//                'watch' => false,                // 关闭实时预览
                'htmlDecode' => 'style,script,iframe|on*',            // 开启 HTML 标签解析，为了安全性，默认不开启
//                'toolbar' => false,             //关闭工具栏
                'previewCodeHighlight' => false, // 关闭预览 HTML 的代码块高亮，默认开启
                'emoji' => true,
                'taskList' => true,
                'tocm' => true,         // Using [TOCM]
                'tex' => true,                   // 开启科学公式TeX语言支持，默认关闭
                'flowChart' => true,             // 开启流程图支持，默认关闭
                'sequenceDiagram' => true,       // 开启时序/序列图支持，默认关闭,
//                'dialogLockScreen' => false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
//                'dialogShowMask' => false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
//                'dialogDraggable' => false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
//                'dialogMaskOpacity' => 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
//                'dialogMaskBgColor' => '#000', // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
                'imageUpload' => true,
                'imageFormats' => ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'webp'],
                //TODO 图片上传地址
                'imageUploadURL' => '/file/blog-upload?type=default&filekey=editormd-image-file',
            ]
        ]
    ) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true, 'placeholder' => '输完一个后按回车键'])?>
    <label class="badge">提示：输入一个标签后请按回车键，若需要多个，请继续输入第二个</label>

    <div class="row">
        <div class="col-xs-12">
            <label for="">热门标签</label>
            <ul class="tag">
            <?php foreach ($hot_tags as $key => $value):
                echo "<li onclick='tags(\"$value\")'><a>$value</a></li>";
             endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="box-footer text-right">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    // $("#blog-tags").val('php');
    function tags(name){
        console.log(name);
    }
</script>
