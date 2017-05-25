<?php

namespace frontend\controllers;

use Yii;
use common\models\Blog;
use common\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\BlogForm;
use common\models\Tags;
use common\models\Category;
use yii\data\Pagination;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/

        $model = new Blog();
        $tagsModel = new Tags();
        $pageSize = Yii::$app->params['pageSize'];
        $get = Yii::$app->request->get();
        $where = array('AND');

        if (isset($get['category'])) {
            $where[] = ['category'=>trim($get['category'])];
        }

        $tags = isset($get['tag']) ? $get['tag'] : '';

        if (isset($get['search_keyword'])) {
            $where[] = [
                'OR', 
                ['category'=>trim($get['search_keyword'])],
                ['LIKE', 'title', trim($get['search_keyword'])],
                ['LIKE', 'content', trim($get['search_keyword'])],
            ];
        }

        $query = empty($tags) ? $model->getBuildQuery($where) : $model->getBuildQuery($where)->innerJoinWith(['blogByTag' => function($q) use($tags) { $q->andWhere(['tag_id' => $tags]); }]);

        $pagination = new Pagination(['totalCount' => $query->count()]);
        $pagination->setPageSize($pageSize);
        $data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            /*->createCommand()->getRawSql();
            echo $data;exit;*/
            ->with('author')
            ->with('categoryInfo')
            ->all();

        $tags = $tagsModel->getTagsIdToName();
        $category = Category::getIdName();

        return $this->render('index', [
            'data' => $data,
            'pagination' => $pagination,
            'tags' => $tags,
            'category' => $category,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
        $blog = new Blog();
        $data = $blog->getOneBlog($id);
        $category = Category::getOneCategory($data->category);
        $tags = Tags::getTagsById(explode(',', $data->tags));

        return $this->render('view', [
            'model' => $data,
            'category' => $category,
            'tags' => $tags
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Blog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
