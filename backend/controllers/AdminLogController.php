<?php 
namespace backend\controllers;

use yii;
use backend\models\AdminLog;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;

class AdminLogController extends Controller
{
    public function actionIndex(){
        $adminLog = new AdminLog();

        $get = Yii::$app->request->get();
        $object = isset($get['object']) ? trim($get['object']) : '';
        $admin_name = isset($get['admin_name']) ? trim($get['admin_name']) : '';
        $where = array();
        $where = ['AND',['LIKE', 'object', $object],['LIKE', 'admin_name', $admin_name]];
        if (isset($get['time_range'])&&strlen(trim($get['time_range']))>0) {
            $range_time = explode('-', $get['time_range']);
            $start_time = $range_time[0];
            $end_time = $range_time[1];
            $where[] = ['BETWEEN', 'record_time', $start_time, $end_time];
        }

        $pageSize = Yii::$app->params['pageSize'];
        $query = AdminLog::find()->filterWhere($where);
        $pagination = new Pagination(['totalCount' => $query->count()]);
        $pagination->setPageSize($pageSize);        

        $datas = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('record_time desc')
            ->all();

        AdminLog::saveLog($this->route, 'opt_search', '查看列表', 1);
        return $this->render('index',['adminLog' => $adminLog, 'datas' => $datas, 'pagination' => $pagination, 'attrbutes' => $adminLog->attributeLabels()]);
    }

}