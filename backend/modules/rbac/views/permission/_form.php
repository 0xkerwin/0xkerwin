<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<link rel="stylesheet" href="/js/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">

<script type="text/javascript" src="/js/zTree/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="/js/zTree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/js/zTree/js/jquery.ztree.excheck.js"></script>

<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= $form->field($menu_item, 'menu_id')->hiddenInput(['value'=> (!isset($menu_id) ? "":$menu_id)])->label('所属模块'); ?>
        <div class="profile-contact-links align-left">
            <div  style="overflow: auto;height: 200px;" >
                <ul id="treeDemo" class="ztree"></ul>
            </div>
        </div>
    </div>

    <div class="box-footer text-right">
        <?= Html::submitButton($model->isNewRecord ? '保存' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    var $j = jQuery.noConflict();
    var setting = {
        check: {
            enable: true,
            chkStyle: "radio",
            radioType: "level"
        },
        radio: {
            enable: true
        },
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "pId",
                rootPId: 0
            }
        },
        async: {
            enable: true,
            type: 'post',
            url:"<?= Url::to(['get-tree']) ?>",
            otherParam: {
                "otherParam":"zTreeAsyncTest",
                "_csrf":"<?= \Yii::$app->request->csrfToken ?>",
                "item_name":"<?= $model->name?>",
            },
            dataFilter: filter
        },
        callback: {
            onCheck: onCheck
        }
    }

    function onCheck(event, treeId, treeNode, clickFlag) {

        var _chkArr = new Array;
        var treeObj = $j.fn.zTree.getZTreeObj("treeDemo");
        var nodes = treeObj.getCheckedNodes(true);

        for(var i=0;i<nodes.length;i++){
            if(nodes[i].isParent == false){
                _chkArr.push(nodes[i].id);
            }
        }

        var nodestr = _chkArr.join(",");
        $("input[id='menuitem-menu_id']").val(nodestr);
    }

    function filter(treeId, parentNode, childNodes) {
        if (!childNodes) return null;
        for (var i=0, l=childNodes.length; i<l; i++) {
            childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
        }

        return childNodes;
    }

    $j(document).ready(function(){
        $j.fn.zTree.init($j("#treeDemo"), setting);
    });
</script>