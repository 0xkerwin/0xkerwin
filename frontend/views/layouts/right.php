<?php 
use yii\helpers\Url;
 ?>
<div id="app" v-cloak>
    <div class="row right-list">
        <div class="col-lg-12">
            <embed width="100%" height="210" name="plugin" id="plugin" src="http://cdn.abowman.com/widgets/hamster/hamster.swf" type="application/x-shockwave-flash">
        </div>
    </div>
    <div class="row right-list">
        <div class="col-lg-12">
            <div class="container-box box-common">
                <h3><i class="fa fa-tags"></i> 热门标签</h3>
                <ul class="tag">
                    <li v-for="(tag, key) in tags['tags']"><a v-on:click="searchTag(key)">{{ tag }}<sup>{{ tags['tags_count'][key] }}</sup></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row right-list">
        <div class="col-lg-12">
            <div class="container-box box-common">
                <h3><i class="fa fa-folder"></i> 分类</h3>
                <ul class="nav">
                    <li v-for="(category, key) in categories['categories']"><a v-on:click="searchCategory(key)">{{ category }}<span class="pull-right badge">{{ categories['categories_count'][key] }}</span></a></li>
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
        },
        methods: {
            searchCategory: function(key) {
                window.location.href = "<?= Url::to('/blog/index') ?>?category="+key;
            },
            searchTag: function(key) {
                window.location.href = "<?= Url::to('/blog/index') ?>?tag="+key;
            }
        }
    });

</script>