<?php 
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\AdminLog;
use backend\models\Category;
use yii\data\Pagination;
use backend\models\Upload;
use yii\web\UploadedFile;

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
        $image_url = '';

        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();

            if ($category->load($post)) {
                $dir = "../../common/web/uploads/images/category/".date("Ymd");
                $image_url = "/uploads/images/category/".date("Ymd");

                if (!is_dir($dir)){
                    mkdir($dir,0777,true);
                }

                $image = UploadedFile::getInstance($category, "image_url");

                if (!$image) {
                    Yii::$app->getSession()->setFlash('error', '上传文件不能为空');
                    return $this->render('create', ['model' => $category, 'image_url' => $image_url]);
                }

                $fileName = time().'_'.$image->name;
                $image_url = $image_url."/".$fileName;
                $dir = $dir."/". $fileName;

                $status = move_uploaded_file($image->tempName, $dir);

                if (!$status) {
                    Yii::$app->getSession()->setFlash('error', '上传失败');
                    return $this->render('create', ['model' => $category, 'image_url' => $image_url]);
                }

                $category->image_url = $image_url;

                if ($category->save(false)) {
                    $msg = '创建分类['.$category->name.']';
                    AdminLog::saveLog($this->route, 'opt_create', $msg, 1);
                    Yii::$app->getSession()->setFlash('success', '创建成功');
                    return $this->redirect(['index']);
                }

            }
        }

        return $this->render('create', ['model' => $category, 'image_url' => $image_url]);
    }

    public function actionUpdate($id)
    {
        $category = $this->findModel($id);
        $image_url = $category->image_url;

        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $image = UploadedFile::getInstance($category, "file");
            
            if ($category->load($post)) {
                if ($image) {
                    $dir = "../../common/web/uploads/images/category/".date("Ymd");
                    $image_url = "/uploads/images/category/".date("Ymd");

                    if (!is_dir($dir)){
                        mkdir($dir,0777,true);
                    }

                    if (!$image) {
                        Yii::$app->getSession()->setFlash('error', '上传文件不能为空');
                        return $this->render('create', ['model' => $category, 'image_url' => $image_url]);
                    }

                    $fileName = time().'_'.$image->name;
                    $image_url = $image_url."/".$fileName;
                    $dir = $dir."/". $fileName;

                    $status = move_uploaded_file($image->tempName, $dir);

                    if (!$status) {
                        Yii::$app->getSession()->setFlash('error', '上传失败');
                        return $this->render('create', ['model' => $category, 'image_url' => $image_url]);
                    }

                    $category->image_url = $image_url;
                }                

                if ($category->save(false)) {
                    $msg = '更新id为['.$category->id.']的分类';
                    AdminLog::saveLog($this->route, 'opt_create', $msg, 1);
                    Yii::$app->getSession()->setFlash('success', '更新成功');
                    return $this->redirect(['index']);
                }

            }
        }

        return $this->render('update', ['model' => $category, 'image_url' => $image_url]);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('您请求的页面不存在');
        }
    }

    /*public function actionCreate()
    {
        $category = new Category();
        $image = new Upload();

        $dir = "../../common/web/uploads/images/category/".date("Ymd");
        $image_url = "uploads/images/category/".date("Ymd");
        if (!is_dir($dir)){
            mkdir($dir,0777,true);
        }

        if (\Yii::$app->request->isPost) {
            $image = UploadedFile::getInstance($category, "image_url");

            if (!$image) {
                Yii::$app->getSession()->setFlash('error', '上传文件不能为空');
                return $this->render('create', ['model' => $category, 'image' => $image]);
            }

            $fileName = time().$image->name;
            $dir = $dir."/". $fileName;

            $status = move_uploaded_file($image->tempName, $dir);

            if ($status) {
                Yii::$app->getSession()->setFlash('error', '上传失败');
            }

            $post = \Yii::$app->request->post();
            if ($category->load($post)) {
                $category->image_url = $image_url.$fileName;
            }
        }

        return $this->render('create', ['model' => $category, 'image' => $image]);
    }*/
}