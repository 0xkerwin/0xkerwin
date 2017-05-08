<?php 
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class CommonController extends Controller
{
    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        /*if (parent::beforeAction($action)) {
            if ($action->id == 'error' && Yii::$app->user->isGuest)
                $this->layout = 'main-login';
            return true;
        } else {
            return false;
        }*/

        if (parent::beforeAction($action)) {
            $user = Yii::$app->user;
            if ($user->isGuest){
                Yii::$app->getResponse()->redirect($user->loginUrl);
            }else{
                if ($user->can('/' . $action->getUniqueId()) || $user->identity->attributes['username']=='admin') {
                    return true;
                }else{
                    throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
                }
            }

        }else {
            return flase;
        }
    }
}