<?php  
namespace backend\modules\rbac\models;

use Yii;
use backend\modules\rbac\models\Item;
/**
* 
*/
class RoleForm extends Item
{
    public $type = \yii\rbac\Item::TYPE_ROLE; /*type为TYPE_ROLE的为角色，默认TYPE_ROLE为1*/

    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['name', 'unique', 'targetClass' => '\backend\modules\rbac\models\RoleForm', 'message' => '{attribute}已经存在。'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '角色名称',
            'type' => '类型',
            'description' => '描述',
            'rule_name' => '规则',
            'data' => '数据',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /*为用户选择角色
    *$username：用户名
    *$role：角色名
    */
    public function saveRole($username, $role)
    {
        $auth = Yii::$app->authManager;
        $user = UserBackend::findByUsername($username);

        if(!$user){
            return false;
        }

        /*先删除自身所有角色*/
        $auth->revokeAll($user->id);

        if(!empty($role)){
            // 增加角色
            foreach ($role as $value) {
                $oneRole = $auth->getRole($value);
                $auth->assign($oneRole, $user->id);
            }
        }

        return true;
    }
}