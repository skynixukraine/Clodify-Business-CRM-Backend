<?php

namespace app\modules\cp\controllers;

use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use app\models\User;
use app\components\AccessRule;
use app\components\Language;
use app\modules\api\models\AccessKey;
use yii\web\Cookie;


class DefaultController extends Controller
{

    public function beforeAction( $action )
    {
        return $this->redirect(Yii::$app->params['url_crm_app']);

    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [ User::ROLE_DEV, User::ROLE_PM, User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_CLIENT, User::ROLE_FIN ],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (User::hasPermission([User::ROLE_DEV, User::ROLE_PM])) {
            
            return $this->redirect(['index/index']);
            
        } elseif (User::hasPermission([User::ROLE_SALES, User::ROLE_CLIENT, User::ROLE_FIN])) {
           
            return $this->redirect(['report/index']);
            
        } elseif (User::hasPermission([User::ROLE_ADMIN])) {
            
            return $this->redirect(['user/index']);
        }
        return $this->redirect(['index/index']);
    }
}
