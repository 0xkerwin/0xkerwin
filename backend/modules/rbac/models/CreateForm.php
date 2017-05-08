<?php
namespace backend\modules\rbac\models;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use yii\base\Model;
use backend\modules\rbac\models\UserBackend;

/**
 * Signup form
 */
class CreateForm extends Model
{
    public $username;
    public $email;
    public $password_hash;
    public $created_at;
    public $updated_at;
    public $role;
    public $verify_password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // 对username的值进行两边去空格过滤
            ['username', 'filter', 'filter' => 'trim'],

            // required表示必须的，也就是说表单提交过来的值必须要有, message 是username不满足required规则时给的提示消息
            ['username', 'required', 'message' => '用户名不可以为空'],

            // unique表示唯一性，targetClass表示的数据模型 这里就是说UserBackend模型对应的数据表字段username必须唯一
            ['username', 'unique', 'targetClass' => '\backend\modules\rbac\models\UserBackend', 'message' => '用户名已存在.'],

            // string 字符串，这里我们限定的意思就是username至少包含2个字符，最多255个字符
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => '邮箱不为空'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\backend\modules\rbac\models\UserBackend', 'message' => 'email已经被设置了.'],
//            ['role', 'required', 'message' => '角色不能为空'],
            ['password_hash', 'required', 'message' => '密码不可以为空'],
            ['password_hash', 'string', 'min' => 6, 'tooShort' => '密码至少填写6位'],
            ['verify_password', 'required', 'message' => '确认密码不能为空'],
            ['verify_password', 'compare', 'compareAttribute'=>'password_hash', 'message' => '确认密码与密码不一致'],
            // default 默认在没有数据的时候才会进行赋值
            [['created_at', 'updated_at'], 'default', 'value' => date('Y-m-d H:i:s')],
        ];
    }

    /**
     * Signs user up.
     *
     * @return true|false 添加成功或者添加失败
     */
    public function signup()
    {
        // 调用validate方法对表单数据进行验证，验证规则参考上面的rules方法
        if (!$this->validate()) {
            return null;
        }
        
        $user = new UserBackend();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->created_at = $this->created_at;   
        $user->updated_at = $this->updated_at;

        // 设置密码，密码肯定要加密，暂时我们还没有实现，看下面我们有实现的代码
        $user->setPassword($this->password_hash);

        // 生成 "remember me" 认证key
        $user->generateAuthKey();        

        // save(false)的意思是：不调用UserBackend的rules再做校验并实现数据入库操作
        // 这里这个false如果不加，save底层会调用UserBackend的rules方法再对数据进行一次校验，因为我们上面已经调用Signup的rules校验过了，这里就没必要在用UserBackend的rules校验了
        return $user->save(false);
    }

    /*为用户选择角色*/
    public function saveRole(){
        $auth = Yii::$app->authManager;
        $user = UserBackend::findByUsername($this->username);

        if(!$user){
            return false;
        }

        /*先删除自身所有角色*/
        $auth->revokeAll($user->id);

        if(!empty($this->role)){
            // 增加角色
            foreach ($this->role as $value) {
                $oneRole = $auth->getRole($value);
                /*给用户赋予角色*/
                $auth->assign($oneRole, $user->id);
            }
        }

        return true;
    }
}
