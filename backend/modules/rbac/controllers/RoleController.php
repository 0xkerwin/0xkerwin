<?php 
namespace backend\modules\rbac\controllers;

use Yii;
use backend\modules\rbac\models\RoleForm;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use backend\modules\rbac\models\Menu;
use backend\modules\rbac\models\MenuItem;
use backend\modules\rbac\models\ItemChild;
use backend\modules\rbac\models\Assignment;
use yii\web\Controller;
use backend\models\AdminLog;

/**
* 
*/
class RoleController extends Controller
{    
    public function actionIndex(){
        $role = new RoleForm();

        $get = Yii::$app->request->get();
        $name = isset($get['name']) ? trim($get['name']) : '';
        $description = isset($get['description']) ? trim($get['description']) : '';
        $where = array();
        $where = ['AND',['LIKE', 'name', $name],['LIKE', 'description', $description]];

        $pageSize = Yii::$app->params['pageSize'];
        $query = RoleForm::getBuildQuery($where)->andWhere(['type' => $role->type]);
        $pagination = new Pagination(['totalCount' => $query->count()]);
        $pagination->setPageSize($pageSize);

        $datas = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

        AdminLog::saveLog($this->route, 'opt_search', '查看列表', 1);
        return $this->render('index',['datas' => $datas, 'pagination' => $pagination, 'attrbutes' => $role->attributeLabels()]);
    }

    public function actionCreate(){
        $model = new RoleForm();
        $item_child = new ItemChild();
        $auth = Yii::$app->authManager;

        if (Yii::$app->request->isPost) {
            $RoleForm = Yii::$app->request->post('RoleForm');
            $permission = !$RoleForm['route'] ? [] : explode(',', $RoleForm['route']);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                /*增加角色*/
                $role = $auth->createRole($model->name);
                $role -> description = $model->description;

                try{
                    /*添加角色*/
                    $auth->add($role);

                    /*给角色添加权限*/
                    if (!$item_child->saveItemChild($model->name, $permission)) {
                        AdminLog::saveLog($this->route, 'opt_create', '角色权限保存失败', 2);
                        Yii::$app->getSession()->setFlash('error', '角色权限保存失败');
                    }

                    AdminLog::saveLog($this->route, 'opt_create', '保存成功', 1);
                    Yii::$app->getSession()->setFlash('success', '保存成功');
                }
                catch(\Exception $ex){
                    Yii::$app->getSession()->setFlash('error', $ex->getMessage());
                }
                return $this->redirect(['index']);
            }else{
                AdminLog::saveLog($this->route, 'opt_create', '保存失败', 2);
                Yii::$app->getSession()->setFlash('error', '保存失败');
            }
        }

        AdminLog::saveLog($this->route, 'opt_show', '查看添加角色', 1);
        return $this->render('create',['model' => $model]);
    }

    public function actionDelete($name){
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $assignment = new Assignment();

        try{
            $user = Assignment::find()->where(['item_name'=>$name])->count();

            if ($user>0) {
                $msg = '角色['.$name.']有用户，不能删除！';
                AdminLog::saveLog($this->route, 'opt_delete', $msg, 2);
                Yii::$app->getSession()->setFlash('error', $msg);
            }else{
                $auth->remove($role);
                /*删除角色的同时，删除角色绑定的权限*/
                $auth->removeChildren($role);
                AdminLog::saveLog($this->route, 'opt_delete', '删除成功', 1);
                Yii::$app->getSession()->setFlash('success', '删除成功');
            }

        }

        catch(\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionUpdate($name){
        $item_child = new ItemChild();
        $model = $this->findModel($name);
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $permission = $item_child->getRes($name);

        if (Yii::$app->request->isPost) {
            $RoleForm = Yii::$app->request->post('RoleForm');
            $route = !$RoleForm['route'] ? [] : explode(',', $RoleForm['route']);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                /*修改角色*/
                
                $role->name = $model->name;
                $role->description = $model->description;

                try{
                    $auth->update($name, $role);

                    /*更新角色权限*/
                    if (!$item_child->saveItemChild($model->name, $route)) {
                        AdminLog::saveLog($this->route, 'opt_update', '角色权限保存失败', 2);
                        Yii::$app->getSession()->setFlash('error', '角色权限保存失败');
                    }

                    AdminLog::saveLog($this->route, 'opt_update', '更新成功', 1);
                    Yii::$app->getSession()->setFlash('success', '更新成功');
                }
                catch(\Exception $ex){
                    Yii::$app->getSession()->setFlash('error', $ex->getMessage());
                }
                return $this->redirect(['index']);
            }else{
                AdminLog::saveLog($this->route, 'opt_update', '更新失败', 2);
                Yii::$app->getSession()->setFlash('error', '更新失败');
            }
        }

        AdminLog::saveLog($this->route, 'opt_show', '查看更新角色', 1);
        return $this->render('create',['model' => $model, 'route' => $permission]);
    }

    protected function findModel($id)
    {
        if (($model = RoleForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*获取权限列表*/
    public function actionGetTree(){
        $menu = new Menu();
        $menu_item = new MenuItem();
        $prentMenu = $menu->getMenuPid();
        $subMenu = $menu->getMenuSub();
        $role = Yii::$app->request->post('role');

        foreach ($prentMenu as $prent) {
            $firstMenu[] = $prent['id'];

            $permission_list[] = ['id' => $prent['id'], 'name' => $prent['name'], 'pId' => 0, 'open' => true];
            foreach ($subMenu as $sub) {
                if ($sub['parent'] == $prent['id']) {

                    $secondMenu[] = $sub['id'];

                    $permission_list[] = ['id' => $sub['id'], 'name' => $sub['name'], 'pId' => $prent['id'], 'open' => true];
                    foreach ($sub->items as $item) {
                        $threeMenu[] = $item['name'];

                        $permission_list[] = ['id' => $item['name'], 'name' => $item['description'], 'pId' => $sub['id'], 'open' => true];
                    }
                }
            }
        }

        if ($role) {
            $auth = Yii::$app->authManager;
            $resList = $auth->getPermissionsByRole($role);
            
            foreach ($resList as $value) {
                $second_id[] = $value->name;
                $id = $menu_item->find()->select('menu_id')->where(['item_name' => $value->name])->one();
                if ($id) {
                    $first_id = $menu->find()->select('parent')->where(['id'=>$id])->one();
                    $second_id[] = $id->menu_id;
                    $first_id && $second_id[] = $first_id->parent;
                }
            }

            if (isset($second_id)) {
                foreach ($second_id as $v) {
                    if (in_array($v, $firstMenu) || in_array($v, $secondMenu) || in_array($v, $threeMenu)) {
                        $keys[] = $v;
                    }
                }

                foreach ($permission_list as $key => $value) {
                    if (in_array($value['id'], $keys)) {
                        $permission_list[$key]['checked'] = true;
                    }
                }
            }            
        }

        !isset($permission_list) && $permission_list=array();
        echo json_encode($permission_list);exit;
    }
}