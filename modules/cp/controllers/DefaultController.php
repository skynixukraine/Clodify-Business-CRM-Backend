<?php

namespace app\modules\cp\controllers;

use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use app\models\User;
use app\components\AccessRule;

class DefaultController extends Controller
{

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
                        'roles' => [ User::ROLE_ADMIN ],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['index/index']);
    }
}
