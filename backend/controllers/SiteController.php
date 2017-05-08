<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\modules\rbac\models\UserBackend;
use backend\models\AdminLog;
use backend\models\Blog;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        // 当前rule将会针对这里设置的actions起作用，如果actions不设置，默认就是当前控制器的所有操作
                        'actions' => ['login', 'error'],
                        // 设置actions的操作是允许访问还是拒绝访问
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        // @ 当前规则针对认证过的用户; ? 所有方可均可访问
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userInfo = new UserBackend();
        $blog = new Blog();
        /*echo "<pre>";
        $session = \Yii::$app->session;
        var_dump($session);exit;*/
        // $menus = Yii::$app->user->identity->getSystemMenus();
        $sysInfo = [
            ['name'=> '操作系统', 'value'=>php_uname('s').' '.php_uname('r').' '.php_uname('v')],
            ['name'=>'PHP版本', 'value'=>phpversion()],
            ['name'=>'Yii版本', 'value'=>Yii::getVersion()],
            ['name'=>'数据库', 'value'=>$this->getDbVersion()],
            ['name'=>'AdminLTE', 'value'=>'V2.3.6'],
            ['name'=>'浏览器版本', 'value'=>$this->getBrowser()],
        ];
        $user_count = $userInfo->getUserCount();
        $blog_count = $blog->getBlogCount();
        AdminLog::saveLog($this->route, 'opt_show', '查看首页', 1, ['model'=>'首页', 'object'=>'首页']);
        return $this->render('index', [
            // 'system_menus' => $menus,
            'sysInfo'=>$sysInfo,
            'userCount' => $user_count,
            'blogCount' => $blog_count,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        // 判断用户是访客还是认证用户 
        // isGuest为真表示访客，isGuest非真表示认证用户，认证过的用户表示已经登录了，这里跳转到主页面
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // 实例化登录模型 common\models\LoginForm
        $model = new LoginForm();

        // 接收表单数据并调用LoginForm的login方法
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            AdminLog::saveLog($this->route, 'opt_login', '登录系统', 1, ['model'=>'登录', 'object'=>'登录']);
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        AdminLog::saveLog($this->route, 'opt_logout', '退出系统', 1, ['model'=>'登出', 'object'=>'登出']);
        Yii::$app->user->logout();

        return $this->goHome();
    }

    private function getDbVersion(){
        $driverName = Yii::$app->db->driverName;
        if(strpos($driverName, 'mysql') !== false){
            $v = Yii::$app->db->createCommand('SELECT VERSION() AS v')->queryOne();
            $driverName = $driverName .'_' . $v['v'];
        }
        return $driverName;
    }

    public function getBrowser() {  
        global $_SERVER;  
        $agent  = $_SERVER['HTTP_USER_AGENT'];  
        $browser  = '';  
        $browser_ver  = '';  
  
        if (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)) {  
            $browser  = 'OmniWeb';  
            $browser_ver   = $regs[2];  
        }  
  
        if (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)) {  
            $browser  = 'Netscape';  
            $browser_ver   = $regs[2];  
        }  
  
        if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {  
            $browser  = 'Safari';  
            $browser_ver   = $regs[1];  
        }  
  
        if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {  
            $browser  = 'Internet Explorer';  
            $browser_ver   = $regs[1];  
        }  
  
        if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {  
            $browser  = 'Opera';  
            $browser_ver   = $regs[1];  
        }  
  
        if (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)) {  
            $browser  = '(Internet Explorer ' .$browser_ver. ') NetCaptor';  
            $browser_ver   = $regs[1];  
        }  
  
        if (preg_match('/Maxthon/i', $agent, $regs)) {  
            $browser  = '(Internet Explorer ' .$browser_ver. ') Maxthon';  
            $browser_ver   = '';  
        }  
        if (preg_match('/360SE/i', $agent, $regs)) {  
            $browser       = '(Internet Explorer ' .$browser_ver. ') 360SE';  
            $browser_ver   = '';  
        }  
        if (preg_match('/SE 2.x/i', $agent, $regs)) {  
            $browser       = '(Internet Explorer ' .$browser_ver. ') 搜狗';  
            $browser_ver   = '';  
        }  
  
        if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {  
            $browser  = 'FireFox';  
            $browser_ver   = $regs[1];  
        }  
  
        if (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)) {  
            $browser  = 'Lynx';  
            $browser_ver   = $regs[1];  
        }  
  
        if(preg_match('/Chrome\/([^\s]+)/i', $agent, $regs)){  
            $browser  = 'Chrome';  
            $browser_ver   = $regs[1];  
  
        }  
  
        if ($browser != '') {
            return $browser.'_'.$browser_ver;  
        } else {
            return '未知浏览器'; 
        }  
    }
}
