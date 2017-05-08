<?php

namespace backend\modules\rbac\controllers;

use Yii;
use backend\modules\rbac\models\UserBackend;
use backend\modules\rbac\models\UserBackendSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\rbac\models\RoleForm;
use yii\helpers\ArrayHelper;
use backend\modules\rbac\models\Assignment;
use backend\modules\rbac\models\CreateForm;
use yii\base\DynamicModel;
use yii\data\Pagination;
use backend\models\AdminLog;

/**
 * UserBackendController implements the CRUD actions for UserBackend model.
 */
class UserBackendController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view'],
                        'allow' => true,
                        // @ 当前规则针对认证过的用户; ? 所有方可均可访问
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all UserBackend models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new UserBackendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
        $user = new UserBackend();
        $query = UserBackend::find();
        $pagination = new Pagination(['totalCount' => $query->count()]);
        $pagination->setPageSize(5);

        $datas = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        AdminLog::saveLog($this->route, 'opt_search', '查看列表', 1);
        return $this->render('index',['datas' => $datas, 'pagination' => $pagination, 'attrbutes' => $user->attributeLabels()]);
    }

    /**
     * Displays a single UserBackend model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserBackend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new UserBackend();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Updates an existing UserBackend model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     *$select_role：该用户已选择的角色
     *$roles：数据库里面已有的角色
     */
    public function actionUpdate($id)
    {
        $adminId = Yii::$app->params['adminId'];
        if ($id == $adminId && Yii::$app->user->identity->getId()!=$adminId)
        {
            Yii::$app->getSession()->setFlash('warning', '您没有执行此操作的权限。');
            return $this->redirect(['index']);
        }

        $model = $this->findModel($id);
        $role_model = new Assignment();
        $role_info = new RoleForm();

        if (!isset($model)) {
            throw new NotFoundHttpException("The user was not found.");
        }

        $model->scenario = 'update';
        $old_password = $model->password_hash;
        $model->password_hash = '';

        $auth = Yii::$app->authManager;
        $select_role = ArrayHelper::map(Assignment::getRoleById($id), 'item_name', 'item_name');

        $roles = ArrayHelper::map($auth->getRoles(), 'name', 'name');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $role_model->load(Yii::$app->request->post())) {

                if ($model->password_hash==='') {
                    $model->password_hash = $old_password;
                }else{
                    /*为密码加密*/
                    $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
                }

                if ($model->validate()) {

                    if($model->save()){
                        $role = $role_info->saveRole($model->username, $role_model->item_name);
                        if ($role) {
                            AdminLog::saveLog($this->route, 'opt_update', '更新成功', 1);
                            Yii::$app->getSession()->setFlash('success', '更新成功。');
                            return $this->redirect(['index']);
                        }else{
                            AdminLog::saveLog($this->route, 'opt_update', '角色更新失败', 2);
                            Yii::$app->getSession()->setFlash('error', '角色更新失败。');
                        }
                    }else{
                        AdminLog::saveLog($this->route, 'opt_update', '更新失败', 2);
                        Yii::$app->getSession()->setFlash('error', '更新失败。');
                    }
                }
            }
        }

        AdminLog::saveLog($this->route, 'opt_update', '查看更新用户', 1);
        return $this->render('update', [
            'model' => $model,
            'role_model' => $role_model,
            'roles' => $roles,
            'select_role' => $select_role,
        ]);
    }

    /**
     * Deletes an existing UserBackend model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $adminId = Yii::$app->params['adminId'];
        if ($id==$adminId){
            Yii::$app->getSession()->setFlash('warning', '此用户为超级管理员，不能删除！');
        }else{
            $auth = Yii::$app->authManager;
            $exist_role = Assignment::find()->where(['user_id' => $id])->one();

            if($this->findModel($id)->delete())
            {
                if($exist_role && !$auth->revokeAll($id))
                {
                    $msg = '用户id为['.$id.']的用户删除成功，但是角色删除失败';
                    AdminLog::saveLog($this->route, 'opt_update', $msg, 2);
                    Yii::$app->getSession()->setFlash('error', $msg);
                }else{
                    $msg = '用户id为['.$id.']的用户删除成功';
                    AdminLog::saveLog($this->route, 'opt_update', $msg, 1);
                    Yii::$app->getSession()->setFlash('success', $msg);
                }
            }else{
                $msg = '用户id为['.$id.']的用户删除失败';
                AdminLog::saveLog($this->route, 'opt_update', $msg, 2);
                Yii::$app->getSession()->setFlash('error', $msg);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserBackend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserBackend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserBackend::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*用户注册*/
    public function actionCreate()
    {
        $model = new CreateForm();
        $auth = Yii::$app->authManager;
        $role = ArrayHelper::map($auth->getRoles(), 'name', 'name');
        
        // 如果是post提交且有对提交的数据校验成功（我们在CreateForm的signup方法进行了实现）
        // $model->load() 方法，实质是把post过来的数据赋值给model
        // $model->signup() 方法, 是我们要实现的具体的添加用户操作
        if (Yii::$app->request->isPost) {

            if (empty($role)) {
                Yii::$app->getSession()->setFlash('danger', '请先添加角色，再添加用户。');
            }else{
                if ($model->load(Yii::$app->request->post()) && $model->signup()) {
                    if($model->saveRole()){
                        AdminLog::saveLog($this->route, 'opt_create', '保存成功', 1);
                        Yii::$app->getSession()->setFlash('success', '保存成功。');
                        return $this->redirect(['index']);
                    }else{
                        AdminLog::saveLog($this->route, 'opt_create', '角色保存失败', 1);
                        Yii::$app->getSession()->setFlash('danger', '角色保存失败。');
                    }
                }else{
                    AdminLog::saveLog($this->route, 'opt_create', '保存失败', 2);
                    Yii::$app->getSession()->setFlash('danger', '保存失败。');
                }
            }
        }

        AdminLog::saveLog($this->route, 'opt_create', '查看创建用户', 1);
        // 渲染添加新用户的表单
        return $this->render('create', [
            'model' => $model,
            'role' => $role,
        ]);
    }

    /*修改密码*/
    public function actionChangePwd($id)
    {
        $model = $this->findModel($id);
        $change_pwd = new UserBackend();

        if (Yii::$app->request->isPost) {
            $change_pwd->scenario = 'change_pwd';
            if ($change_pwd->load(Yii::$app->request->post()) && $change_pwd->validate()) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($change_pwd->new_password);                
                
                if($model->save(false)){
                    Yii::$app->getSession()->setFlash('success', '密码更新成功。');
                    return $this->redirect(['index']);
                }else{
                    Yii::$app->getSession()->setFlash('error', '密码更新失败。');
                }

            }
        }

        return $this->render('change-pwd', ['model' => $model, 'change_pwd' => $change_pwd]);
    }
}
