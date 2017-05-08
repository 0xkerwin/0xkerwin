<?php
namespace backend\modules\rbac\components;

use yii\web\ForbiddenHttpException;
use Yii;
use yii\base\Module;
use yii\web\User;
use yii\di\Instance;

class AccessControl extends \yii\base\ActionFilter
{
    /**
     * @var User User for check access.
     */
    private $_user = 'user';

    /**
     * Get user
     * @return User
     */
    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }
        return $this->_user;
    }

    /**
     * Set user
     * @param User|string $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $user = $this->getUser();
        $adminId = Yii::$app->params['adminId'];//超级管理员的id
        /*admin超级管理员不需要限制权限*/
        if (isset($user->identity->username) && $user->identity->getId()==$adminId) {
            return true;
        }
        
        if ($user->can('/'.$action->getUniqueId()) || in_array($action->getUniqueId(),$this->_allowActions($user))) {

            return true;
        }
        
        $this->denyAccess($user);
    }

    /**
     * @param $user
     * @throws ForbiddenHttpException
     */
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * @inheritdoc
     */
    protected function isActive($action)
    {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }
        return true;
    }

    /**
     * 排除的Action 比如ajax请求,错误页面等
     */
    private function _allowActions($user){
        if ($user->getIsGuest()) {
            return [
                'site/error',
                'site/logout',
                'site/login',
                'site/captcha',
            ];
        }else{
            return [
                'site/error',
                'site/index',
                'role/get-tree',/*ajax获取角色列表*/
                'permission/get-tree',/*ajax获取权限列表*/
                'site/logout',
                'site/login',
                'site/captcha',
                'file/upload',
            ];
        }
    }
}