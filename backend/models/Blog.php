<?php 
namespace backend\models;

use Yii;
use backend\modules\rbac\models\UserBackend;

 /**
 * 
 */
 class Blog extends \common\models\Blog
 {
    public function getBlog()
    {
        $query = $this->getBuildQuery();

        $res = $query->with('author')
            ->with('mender')
            ->all();

        return $res;
    }

    /*
    * 获取修改者信息
    */
    public function getMender()
    {
        return $this->hasOne(UserBackend::className(), ['id' => 'edit_id']);
    }
 }