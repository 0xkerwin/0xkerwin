<?php 
namespace backend\models;

use Yii;
use backend\modules\rbac\models\UserBackend;

 /**
 * 
 */
 class Blog extends \common\models\Blog
 {
     
    public function getBuildQuery($where=[])
    {
        $data = self::find()->where($where)->orderBy('create_time desc');

        return $data;
    }

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