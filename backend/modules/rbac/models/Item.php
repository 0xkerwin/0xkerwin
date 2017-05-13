<?php 
namespace backend\modules\rbac\models;

use Yii;

/**
* 
*/
class Item extends \common\models\AuthItem
{
    /*获取角色*/
    public function getRole($conditions=[], $fields='*'){
        $result = static::getBuildQuery($conditions, $fields)->andWhere(['type' => \yii\rbac\Item::TYPE_ROLE])->all();

        return $result;
    }

    /*获取权限*/
    public function getPermission($conditions=[], $fields='*'){
        $result = static::getBuildQuery($conditions, $fields)->andWhere(['type' => \yii\rbac\Item::TYPE_PERMISSION])->all();

        return $result;
    }

    /*生成查询*/
    public static function getBuildQuery($conditions=1, $fields='*'){
        $query = static::find()->select($fields)->filterWhere($conditions);

        return $query;
    }
}
