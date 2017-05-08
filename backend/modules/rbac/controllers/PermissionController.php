<?php 
namespace backend\modules\rbac\controllers;

use Yii;
use backend\modules\rbac\controllers\CommonController;
use backend\modules\rbac\models\PermissionForm;
use yii\data\Pagination;
use backend\modules\rbac\models\MenuItem;
use backend\modules\rbac\models\Menu;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use backend\models\AdminLog;
/**
* 
*/
class PermissionController extends Controller
{
    public function actionIndex(){
        // $auth = Yii::$app->authManager;
        // $permission = $auth -> getPermissions();
        $permission = new PermissionForm();
        $query = PermissionForm::getBuildQuery()->andWhere(['type' => $permission->type]);
        $pagination = new Pagination(['totalCount' => $query->count()]);
        $pagination->setPageSize(5);

        $datas = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

        AdminLog::saveLog($this->route, 'opt_search', '查看列表', 1);
        return $this->render('index',['datas' => $datas, 'pagination' => $pagination, 'attrbutes' => $permission->attributeLabels()]);
    }

    public function actionCreate(){
        $model = new PermissionForm();
        $menu_item = new MenuItem();
        $auth = Yii::$app->authManager;

        if (Yii::$app->request->isPost) {

            if ($model->load(Yii::$app->request->post()) && $menu_item->load(Yii::$app->request->post())) {
                $menu_item->item_name = $model->name;
                if ($model->validate() && $menu_item->validate()) {

                    /*增加许可*/
                    $permission = $auth->createPermission($model->name);
                    $permission->description = $model->description;

                    try{
                        $auth->add($permission);
                        if ($menu_item->save()) {
                            AdminLog::saveLog($this->route, 'opt_create', '保存成功', 1);
                            Yii::$app->getSession()->setFlash('success', '保存成功');
                        }else{
                            AdminLog::saveLog($this->route, 'opt_create', '所属模块保存失败', 2);
                            Yii::$app->getSession()->setFlash('error', '所属模块保存失败！');
                        }
                    }
                    catch(\Exception $ex){
                        Yii::$app->getSession()->setFlash('error', $ex->getMessage());
                    }
                    return $this->redirect(['index']);
                }
                
            }else{
                AdminLog::saveLog($this->route, 'opt_create', '保存失败', 2);
                Yii::$app->getSession()->setFlash('error', '保存失败');
            }
        }

        AdminLog::saveLog($this->route, 'opt_show', '查看权限创建', 1);
        return $this->render('create',['model' => $model, 'menu_item' => $menu_item]);
    }

    public function actionUpdate($name){
        // var_dump($name);exit;
        $model = $this->findModel($name);
        $menu_item = new MenuItem();
        $menuItem = MenuItem::find()->where(['item_name'=>$name])->one();
        $auth = Yii::$app->authManager;
        $menu_id = $menu_item->getMenuIdByItemName($name);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $menuItem->load(Yii::$app->request->post())) {
                $menuItem->item_name = $model->name;
                if ($model->validate() && $menuItem->validate()) {
                    /*修改权限*/
                    $permission = $auth->getPermission($name);
                    $permission->name = $model->name;
                    $permission->description = $model->description;

                    try{
                        $auth->update($name, $permission);
                        if ($menuItem->save()) {
                            AdminLog::saveLog($this->route, 'opt_update', '更新成功', 1);
                            Yii::$app->getSession()->setFlash('success', '更新成功');
                        }else{
                            AdminLog::saveLog($this->route, 'opt_update', '所属模块更新失败', 2);
                            Yii::$app->getSession()->setFlash('error', '所属模块更新失败！');
                        }
                    }
                    catch(\Exception $ex){
                        Yii::$app->getSession()->setFlash('error', $ex->getMessage());
                    }
                    return $this->redirect(['index']);
                }
                
            }else{
                AdminLog::saveLog($this->route, 'opt_update', '更新失败', 2);
                Yii::$app->getSession()->setFlash('error', '更新失败');
            }
        }

        AdminLog::saveLog($this->route, 'opt_show', '查看更新权限', 1);
        return $this->render('update',['model' => $model, 'menu_item' => $menu_item, 'menu_id' => $menu_id ? $menu_id->menu_id : '']);
    }

    public function actionDelete($name){
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        $menuItem = MenuItem::find()->where(['item_name'=>$name])->one();

        try{
            if ($menuItem->delete() && $auth->remove($permission)) {
                AdminLog::saveLog($this->route, 'opt_delete', '删除成功', 1);
                Yii::$app->getSession()->setFlash('success', '删除成功');
            }else{
                AdminLog::saveLog($this->route, 'opt_delete', '删除失败', 2);
                Yii::$app->getSession()->setFlash('error', '删除失败');
            }
            
        }
        catch(\Exception $ex){
            Yii::$app->getSession()->setFlash('error', $ex->getMessage());
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = PermissionForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetTree(){
        $menu = new Menu();
        $menu_item = new MenuItem();
        $item_name = Yii::$app->request->post('item_name');
        $menu_id = $menu_item->getMenuIdByItemName($item_name);

        $prentMenu = $menu->getMenuPid();
        $subMenu = $menu->getMenuSub();

        foreach ($prentMenu as $prent) {
            $firstMenu[] = $prent['id'];
            $menu_list[] = ['id' => $prent['id'], 'name' => $prent['name'], 'pId' => 0, 'open' => true];
            foreach ($subMenu as $sub) {
                if ($sub['parent'] == $prent['id']) {
                    $secondMenu[] = $sub['id'];
                    $menu_list[] = ['id' => $sub['id'], 'name' => $sub['name'], 'pId' => $prent['id'], 'open' => true];
                }
            }
        }

        if ($menu_id) {
            foreach ($menu_list as $key => $value) {
                if ($menu_id->menu_id == $value['id']) {
                    $menu_list[$key]['checked'] = true;
                }
            }
        }

        !isset($menu_list) && $menu_list=array();
        echo json_encode($menu_list);exit;
    }
}