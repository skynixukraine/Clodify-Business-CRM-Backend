<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 21.03.16
 * Time: 15:41
 */
namespace app\modules\cp\controllers;
use app\components\DateUtil;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
class TeammateController extends DefaultController
{
    public $enableCsrfValidation = false;
    public $layout = "admin";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions'   => [ 'index'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get']
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


}