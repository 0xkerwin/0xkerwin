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
        $pageSize = Yii::$app->params['pageSize'];
        $query = AdminLog::find();
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