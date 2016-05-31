<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 30.05.16
 * Time: 10:21
 */
namespace app\controllers;

use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\models\SupportTicket;


class SupportController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = "main_en";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionIndex()
    {
        /** @var  $model SupportTicket*/
        $model = new SupportTicket();
        if( ( Yii::$app->request->isAjax &&
            Yii::$app->request->isGet &&
            ($data = Yii::$app->request->get('query'))) ) {

            return json_encode([
                "success" => $data
            ]);
        }
            if ( $model->load(Yii::$app->request->post()) ) {
            $supportTicket = SupportTicket::supportSearch(SupportTicket::classname());
            SupportTicket::loadMultiple($supportTicket, Yii::$app->request->post());
            //var_dump($supportTicket);die();
            /*if ($model != null) {
                if ( $model->is_private == 0){

                }
            }*/
            if ($model->validate()) {
                $model->save();
            }
        }
        return $this->render('index' ,['model' => $model]);
    }
}
