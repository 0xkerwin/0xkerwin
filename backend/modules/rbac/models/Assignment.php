<?php 
namespace backend\modules\rbac\models;

use Yii;

/**
* 
*/
class Assignment extends \common\models\AuthAssignment
{
    public function rules()
    {
        return [
            ['item_name', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'item_name' => '所属角色',
        ];
    }

    public static function getRoleById($id){
        $role = static::find()->where(['user_id' => $id])->all();

        return $role;
    }
}

