<?php 
namespace backend\modules\rbac\models;

use Yii;

/**
* 
*/
class ItemChild extends \common\models\AuthItemChild
{
    /*保存角色权限
    *$role:角色名称
    *$permission:角色权限
    */
    public function saveItemChild($role, $permission=[])
    {
        $auth = Yii::$app->authManager;
        $oneRole = $auth->getRole($role);
        $rolePermission = array_keys($auth->getPermissionsByRole($role));  /*获取角色所有权限*/

        /*对比提交数据与原先是否一致，若一致则不更新*/
        if (!array_diff($permission,$rolePermission) && !array_diff($rolePermission,$permission)) {
            return true;
        }else{
            
            if (!empty($rolePermission) || !$permission) {
                $auth->removeChildren($oneRole);/*删除该角色的所有权限*/
            }

            if ($permission) {
                foreach ($permission as $value) {
                    
                    $onePermission = $auth->getPermission($value); /*读取$permission的权限*/

                    /*增加权限*/
                    if(!$auth->addChild($oneRole , $onePermission)){
                        return false;
                    }
                }
            }           

        }

        return true;
    }

    /**
     * 获取角色下的权限
     * @param $roles
     * @param $uid
     */
    public static function getRes($role){
        $auth = Yii::$app->authManager;
        $list = $auth->getPermissionsByRole($role);
        $newList = [];
        if($list){
            foreach($list as $item){
                $newList[] = $item->name;
            }
        }

        return empty($newList) ? "": implode(',',$newList);
    }
}
