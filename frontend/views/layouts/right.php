<?php 
use yii\helpers\Url;
 ?>
<div id="app" v-cloak>
    <div class="row right-list">
        <div class="col-lg-12">
            <div class="container-box box-common">
                <h3><i class="fa fa-tags"></i> 热门标签</h3>
                <ul class="tag">
                    <li v-for="(tag, key) in tags"><a href="#">{{ tag }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row right-list">
        <div class="col-lg-12">
            <div class="container-box box-common">
                <h3><i class="fa fa-folder"></i> 分类</h3>
                <ul class="nav">
                    <li v-for="(category, key) in categories"><a href="#">{{ category }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var vm = new Vue({
        el: '#app',
        data: {
            tags: [],
            categories: [],
        },
        created: function(){
            var self = this;
            $.ajax({
                url:"<?= Url::to(['/site/right']) ?>",
                type: 'post',
                dataType: 'json',
                data: {"_csrf-frontend":"<?= \Yii::$app->request->csrfToken ?>"},
                success: function(res){
                    self.tags = res.tags;
                    self.categories = res.categories;
                }
            });
        }
    });

</script>