<?php 
namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Blog;
use yii\data\Pagination;
use backend\models\AdminLog;
use common\models\Category;
use common\models\Tags;
use common\models\TagMap;

/**
* 
*/
class BlogController extends Controller
{
    public function actionIndex()
    {
        $blog = new Blog();

        $get = Yii::$app->request->get();
        $title = isset($get['title']) ? trim($get['title']) : '';
        $content = isset($get['content']) ? trim($get['content']) : '';
        $author = isset($get['author']) ? trim($get['author']) : '';
        $where = array();
        $where = ['AND',['LIKE', 'title', $title],['LIKE', 'content', $content]];

        if (isset($get['time_range'])&&strlen(trim($get['time_range']))>0) {
            $range_time = explode('-', $get['time_range']);
            $start_time = $range_time[0];
            $end_time = $range_time[1];
            $where[] = ['BETWEEN', 'create_time', $start_time, $end_time];
        }

        $pageSize = Yii::$app->params['pageSize'];
        $query = $blog->getBuildQuery($where)
            ->innerJoinWith(['author' => function($q) use($author) {
                $q->andWhere(['LIKE', 'username', $author]);
            },])
            ->with('mender');

        $pagination = new Pagination(['totalCount' => $query->count()]);
        $pagination->setPageSize($pageSize);

        $datas = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        AdminLog::saveLog($this->route, 'opt_search', '查看列表', 1);
        return $this->render('index',['datas' => $datas, 'pagination' => $pagination, 'attrbutes' => $blog->attributeLabels()]);
    }

    public function actionCreate()
    {
        $model = new Blog();
        $categoryModel = new Category();
        $user = Yii::$app->user->identity;
        $post = Yii::$app->request->post();
        $category = Category::getIdName();
        $tags = new Tags();
        $tagMap = new TagMap();

        if (Yii::$app->request->isPost){
            $tag = empty($post['Blog']['tags']) ? '' : $tags->getTagsByName(array_unique(explode(',', $post['Blog']['tags'])));

            if ($tag !== false) {
                $post['Blog']['tags'] = $tag;
                if ($model->load($post) && $model->validate()) {
                    $model->user_id = $user->id;
                    $msg = '创建标题为['.$model->title.']的博客';
                    if($model->save(false)){
                        $tags->addCount(explode(',', $model->tags));
                        $categoryModel->addCount($model->category);
                        !empty($model->tags) && $tagMap->addMap($model->id, explode(',', $model->tags));

                        AdminLog::saveLog($this->route, 'opt_create', $msg, 1);
                        Yii::$app->getSession()->setFlash('success', '创建成功');
                        return $this->redirect(['index']);
                    }else{
                        AdminLog::saveLog($this->route, 'opt_create', $msg, 2);
                        Yii::$app->getSession()->setFlash('error', '创建失败');
                        return $this->render('create', [
                            'model' => $model,
                            'category' => $category,
                        ]);
                    }

                }
            }else{
                AdminLog::saveLog($this->route, 'opt_create', '标签添加失败', 2);
                Yii::$app->getSession()->setFlash('error', '标签添加失败');
                return $this->redirect('create');
            }
        } else {
            AdminLog::saveLog($this->route, 'opt_show', '查看添加博客', 1);
            return $this->render('create', [
                'model' => $model,
                'category' => $category,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $tags = new Tags();
        $tagMap = new TagMap();
        $categoryModel = new Category();
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        $user = Yii::$app->user->identity;
        $category = Category::getIdName();
        $old_tags = $model->tags;
        $old_category = $model->category;
        $model->tags = Tags::getTagsById(explode(',', $model->tags));

        if (Yii::$app->request->isPost) {
            $tag = $tags->getTagsByName(array_unique(explode(',', $post['Blog']['tags'])));
            if ($tag !== false) {
                $post['Blog']['tags'] = $tag;

                if ($model->load($post) && $model->validate()) {
                    $model->edit_id = $user->id;
                    $msg = '更新ID为['.$id.']的博客';
                    if($model->save(false)){
                        /*更新标签中的总数*/
                        $tags->updateCount(explode(',', $old_tags), explode(',', $model->tags));
                        $categoryModel->updateCount($old_category, $model->category);
                        $tagMap->updateMap($id, explode(',', $model->tags));

                        AdminLog::saveLog($this->route, 'opt_update', $msg, 1);
                        Yii::$app->getSession()->setFlash('success', '更新成功');
                        return $this->redirect(['index']);
                    }else{
                        AdminLog::saveLog($this->route, 'opt_update', $msg, 2);
                        Yii::$app->getSession()->setFlash('error', '更新失败');
                        return $this->render('update', [
                            'model' => $model,
                            'category' => $category
                        ]);
                    }
                }
            }else{
                AdminLog::saveLog($this->route, 'opt_update', '标签添加失败', 2);
                Yii::$app->getSession()->setFlash('error', '标签添加失败');
                return $this->redirect('create');
            }
            
        } else {
            AdminLog::saveLog($this->route, 'opt_show', '查看ID为['.$id.']的博客更新界面', 1);
            return $this->render('update', [
                'model' => $model,
                'category' => $category
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $tags = new Tags();
        $category = new Category();
        $tagMap = new TagMap();
        $tags_id = $model->tags;
        $category_id = $model->category;

        $msg = '删除ID为['.$id.']的博客';
        if ($model->delete()) {
            $tags->deleteTags(explode(',', $tags_id));
            $category->subtractCount($category_id);
            $tagMap->deleteMap($id);

            AdminLog::saveLog($this->route, 'opt_delete', $msg, 1);
            Yii::$app->getSession()->setFlash('success', '删除成功');
        }else{
            AdminLog::saveLog($this->route, 'opt_delete', $msg, 2);
            Yii::$app->getSession()->setFlash('error', '删除失败');
        }

        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        $blog = new Blog();
        $data = $blog->getOneBlog($id);
        $category = Category::getOneCategory($data->category);
        $tags = Tags::getTagsById(explode(',', $data->tags));
        AdminLog::saveLog($this->route, 'opt_show', '查看ID为['.$id.']的博客', 1);
        return $this->render('view', [
            'model' => $data,
            'category' => $category,
            'tags' => $tags
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('您请求的页面不存在');
        }
    }
}