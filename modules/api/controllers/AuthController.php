<?php
/**
 * Created by Skynix Team
 * Date: 03.01.17
 * Time: 17:37
 */

namespace app\modules\api\controllers;

use Yii;
use app\models\User;
use app\models\LoginForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\ActiveController;

class AuthController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login'  => ['post']
                ],
            ],
        ];
    }
    public function actionIndex(){
        $loginForm = new LoginForm();
        die('11111');
        $json = Yii::$app->request->getRawBody();
        $postData = @json_decode($json, true);

        if($loginForm->validate()
            && $loginForm->getUser()->is_delete == 0
            && $loginForm->getUser()->is_active == 1
        ) {

        }
    }
}