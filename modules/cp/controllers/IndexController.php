<?php
/**
 * Created by WebAIS.
 * User: Wolf
 * Date: 02.10.2015
 * Time: 10:38
 */

namespace app\modules\cp\controllers;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\AccessRule;

class IndexController extends Controller
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
                        'actions' => [ 'index' ],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN ],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'      => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

}