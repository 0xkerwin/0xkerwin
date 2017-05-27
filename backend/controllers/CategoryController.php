<?php 
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\AdminLog;
use backend\models\Category;
use yii\data\Pagination;

/**
* 
*/
class CategoryController extends Controller
{
    
    public function actionIndex()
    {
        $category = new Category;
        $get = \Yii::$app->request->get();
        $category_name = isset($get['name']) ? $get['name'] : '';
        $where = array();
        $where = ['LIKE', 'name', $category_name];

        $pageSize = Yii::$app->params['pageSize'];
        $query = Category::find()->filterWhere($where);
        $pagination = new Pagination(['totalCount' => $query->count()]);
        $pagination->setPageSize($pageSize);        

        $datas = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('create_time desc')
            ->all();

        AdminLog::saveLog($this->route, 'opt_search', '查看列表', 1);
        return $this->render('index',['datas' => $datas, 'pagination' => $pagination, 'attrbutes' => $category->attributeLabels()]);
    }

    public function actionCreate()
    {
        $category = new Category();

        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            if ($category->load($post)) {
                
            }
        }

        return $this->render('create', ['model' => $category]);
    }
}