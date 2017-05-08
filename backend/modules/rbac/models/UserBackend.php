<?php

namespace backend\modules\rbac\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user_backend".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 */
class UserBackend extends \yii\db\ActiveRecord implements IdentityInterface
{
    const EDIT_PSW = 1;
    const EDIT_PROFILE = 2;
    //确认新密码.
    public $verify_new_password;
    //密码.
    public $new_password;
    //验证码.
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_backend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required', 'on'=>'create'],
            [['username', 'email'], 'required', 'on'=>'update'],
            [['password_hash','new_password','verify_new_password'],'required','on'=>'change_pwd' ],
            [['new_password','verify_new_password'],'string','length'=>[6,15],'on'=>'change_pwd','message'=>'密码长度为6到15位' ],
            ['verify_new_password', 'compare', 'compareAttribute'=>'new_password','on'=>'change_pwd'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['password_hash',function ($attribute, $params){
                $password =  $this->$attribute;
                $username = \Yii::$app->user->identity->username;
                $userInfo = self::findOne(['username'=>$username]);
                if(\Yii::$app->getSecurity()->validatePassword($password,$userInfo->password_hash))
                {
                    return true;
                }
                else 
                {
                    $this->addError($attribute,"用户原密码错误");
                }
            },'on'=>'change_pwd' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '用户密码',
            'new_password' => '新密码',
            'verify_new_password' => '确认新密码',
            'email' => 'Email',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * 根据user_backend表的主键（id）获取用户
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     * 根据access_token获取用户，我们暂时先不实现，我们在文章 http://www.manks.top/yii2-restful-api.html 有过实现，如果你感兴趣的话可以看看
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     * 用以标识 Yii::$app->user->id 的返回值
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     * 获取auth_key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     * 验证auth_key
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 为model的password_hash字段生成密码的hash值
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 生成 "remember me" 认证key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Finds user by username
     * 根据user_backend表的username获取用户
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Validates password
     * 验证密码的准确性
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getUserCount()
    {
        $count = static::find()->count();

        return $count;
    }
}
