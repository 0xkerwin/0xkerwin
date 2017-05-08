<?php
namespace backend\modules\rbac;
use yii\base\Module as BaseModule;
class Module extends BaseModule
{
    public $modelMap = [];
    /** @var bool Whether to show flash messages. */
    public $enableFlashMessages = true;
    public $controllerNamespace = 'backend\modules\rbac\controllers';
    public function init()
    {
        parent::init();
    }
}