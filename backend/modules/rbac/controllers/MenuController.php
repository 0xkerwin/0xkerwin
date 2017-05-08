<?php 
namespace backend\modules\rbac\controllers;

use Yii;
use backend\modules\rbac\models\Menu;
use yii\data\Pagination;
use backend\modules\rbac\controllers\CommonController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use backend\models\AdminLog;

class MenuController extends Controller
{
	public function actionIndex()
	{
		$menu = new Menu();
		$query = Menu::getBuildQuery();
        $pagination = new Pagination(['totalCount' => $query->count()]);
        $pagination->setPageSize(5);

        $datas = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

        AdminLog::saveLog($this->route, 'opt_search', '查看列表', 1);
        return $this->render('index',['datas' => $datas, 'pagination' => $pagination, 'attrbutes' => $menu->attributeLabels()]);
	}

	public function actionCreate()
	{
		$model = new Menu();
		$parent = ArrayHelper::map($model->getMenuPid(), 'id', 'name');

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post()) && $model->validate()) {
				if ($model->save()) {
                    AdminLog::saveLog($this->route, 'opt_create', '保存成功', 1);
					Yii::$app->getSession()->setFlash('success', '保存成功');
					return $this->redirect(['index']);
				}else{
                    AdminLog::saveLog($this->route, 'opt_create', '保存失败', 2);
					Yii::$app->getSession()->setFlash('error', '保存失败');
				}
			}else{
                Yii::$app->getSession()->setFlash('error', '保存失败');
            }
		}

        AdminLog::saveLog($this->route, 'opt_show', '创建菜单', 1);
		return $this->render('create',['model' => $model, 'parent' => $parent]);
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$parent = ArrayHelper::map($model->getMenuPid(), 'id', 'name');

		if (Yii::$app->request->isPost) {
			if ($model->load(Yii::$app->request->post()) && $model->validate()) {
				if ($model->save()) {
                    AdminLog::saveLog($this->route, 'opt_update', '更新成功', 1);
					Yii::$app->getSession()->setFlash('success', '更新成功');
					return $this->redirect(['index']);
				}else{
                    AdminLog::saveLog($this->route, 'opt_update', '更新失败', 2);
					Yii::$app->getSession()->setFlash('error', '更新失败');
				}
			}else{
                AdminLog::saveLog($this->route, 'opt_update', '更新失败', 2);
                Yii::$app->getSession()->setFlash('error', '更新失败');
            }
		}

        AdminLog::saveLog($this->route, 'opt_show', '更新菜单', 1);
		return $this->render('update',['model' => $model, 'parent' => $parent]);
	}

	public function actionDelete($id)
	{
		$model = new Menu();

		if ($model->getMenuByParet($id)) {
		    $msg = '菜单id为['.$id.']的菜单含有子菜单，若要删除，请先删除子菜单';
            AdminLog::saveLog($this->route, 'opt_delete', $msg, 2);
			Yii::$app->getSession()->setFlash('warning', $msg);
			return $this->redirect(['index']);
		}

		if ($this->findModel($id)->delete()) {
		    $msg = '菜单id为['.$id.']的菜单删除成功';
            AdminLog::saveLog($this->route, 'opt_delete', $msg, 1);
			Yii::$app->getSession()->setFlash('success', $msg);
		}else{
		    $msg = '菜单id为['.$id.']的菜单删除失败。';
            AdminLog::saveLog($this->route, 'opt_delete', $msg, 2);
			Yii::$app->getSession()->setFlash('error', $msg);
		}

		return $this->redirect(['index']);
	}

	public function findModel($id)
	{
		if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
	}
}