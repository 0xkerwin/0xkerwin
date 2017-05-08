<?php 
namespace backend\models;

use Yii;
use backend\modules\rbac\models\Menu;

/**
 * This is the model class for table "{{%article}}".
 **/
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '操作记录ID',
            'admin_id' => '操作用户ID',
            'record_time' => '记录时间',
            'admin_name' => '操作用户名',
            'admin_ip' => '操作人IP地址',
            'description' => '操作记录描述',
            'route' => '操作路由',
            'model' => '操作模块',
            'object' => '操作对象',
            'type' => '操作类型',
            'result' => '操作结果'
        ];
    }

    /*
     * $route：路由
     * $description：记录描述
     * $type：操作类型
     * 'operate_type' => [
     *      ['opt_search' => '查询'],
     *      ['opt_create' => '创建'],
     *      ['opt_delete' => '删除'],
     *      ['opt_opdate' => '修改'],
     *      ['opt_show' => '查看'],
     *      ['opt_export' => '导出'],
     *      ['opt_import' => '导入']
     *  ],
     * $result：操作结果（1、成功；2、失败）
     * $other：其他特殊操作（登入，登出等）
     * */
    public static function saveLog($route, $type, $description, $result, $other=array()){

        $model = new self;
        $user = Yii::$app->user;
        $model->admin_id = $user->identity->id;
        $model->admin_name = $user->identity->username;
        $model->admin_ip = Yii::$app->request->userIP;
        $model->record_time = time();
        $model->route = $route;
        $route_arr = explode('/', $route);
        $route = rtrim($route, end($route_arr));
        $menu = Menu::find()->select('name,parent')->where(['LIKE','route',$route])->one();

        if ($menu){
            $model->object = $menu->name;
            $parent = Menu::find()->select('name')->where(['id' => $menu->parent])->one();
            $model->model = $parent ? $parent->name : '';
        }else{
            if (!empty($other)){
                $model->model = $other['model'];
                $model->object = $other['object'];
            }else{
                $model->object = '';
                $model->model = '';
            }
        }

        $model->description = $description;
        $model->type = self::operateType($type, 'key');
        $model->result = $result;

        $model->save(false);

    }

    /*
     * $opt：操作类型
     * $type：获取类型（key：获取操作代码；value：获取操作名称）
     * */
    public static function operateType($opt, $type='key')
    {
        $option_type = Yii::$app->params['operate_type'];
        foreach ($option_type as $key => $value){
            if ($type=='key' && $opt==current(array_keys($value))){
                return $key;
            }
            if ($type=='value' && $opt==$key){
                return current($value);
            }
        }

        return 0;
    }
}