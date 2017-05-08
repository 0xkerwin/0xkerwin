<?php  
namespace backend\modules\rbac\models;

/**
* 
*/
class PermissionForm extends Item
{
    public $type = \yii\rbac\Item::TYPE_PERMISSION; /*type为TYPE_PERMISSION的为权限，默认TYPE_PERMISSION为2*/

    public function rules()
    {
        return [
            [['name', 'type', 'description'], 'required'],
            ['name', 'unique', 'targetClass' => '\backend\modules\rbac\models\PermissionForm', 'message' => '{attribute}已存在。'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '权限名称',
            'type' => '类型',
            'description' => '描述',
            'rule_name' => '规则',
            'data' => '数据',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}