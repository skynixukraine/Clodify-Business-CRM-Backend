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
                        'actions' => ['index', 'submit-request', 'upload'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'submit-request', 'upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
             'verbs' => [
                    'class' => VerbFilter::className(),
                        'actions' => [
                            'index' => ['get', 'post'],
                            'submit-request' => ['get', 'post'],
                            'upload'=> ['get', 'post'],
                        ],
                ],
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
        /** @var  $model SupportTicket */
        $model = new SupportTicket();
        if ((Yii::$app->request->isAjax &&
            Yii::$app->request->isGet &&
            ($data = Yii::$app->request->get('query')))
        ) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $words = explode(' ', $data);
            /*return json_encode([
                "success" => $words
            ]);*/
            //$subjectId = [];

            foreach ($words as $word) {
                $subjects = SupportTicket::getSupport($word);
                foreach ($subjects as $subject) {
                    $subjectId[$subject->id] = $subject->subject;

                }

                //var_dump($subject);die();

            }
            if (!isset($subjectId)) {
                return [
                    "error" => true
                ];
            } else {
                return $subjectId;
                //return  $subjectId;

            }

        }
        /*if ( $model->load(Yii::$app->request->post()) ) {*/
        /*$supportTicket = SupportTicket::getSupport(SupportTicket::classname());
        SupportTicket::loadMultiple($supportTicket, Yii::$app->request->post());*/
        //var_dump($supportTicket);die();
        /*if ($model != null) {
            if ( $model->is_private == 0){

            }
        }*/
        /*if ($model->validate()) {
            $model->save();
        }*/
        // }
        return $this->render('index', ['model' => $model]);
    }

    public function actionSubmitRequest()
    {
        $model = new SupportTicket();
        $model->email = Yii::$app->user->identity->email;
        return $this->render('submit-request', ['model' => $model]);
    }

    /* public function actionUpload()
     {

         $fileName = 'file';
         $uploadPath = __DIR__ . '/../../../data/' . 'ticket/' ;
         if (!file_exists($uploadPath))
         {
             mkdir($uploadPath, 0777, true);
             chmod($uploadPath, 0777);
         }
         $uploadPath = $uploadPath . 'temp/';
         if (!file_exists($uploadPath))
         {
             mkdir($uploadPath, 0777, true);
             chmod($uploadPath, 0777);
         }

         if (isset($_FILES[$fileName])) {
             $file = \yii\web\UploadedFile::getInstanceByName($fileName);

             //Print file data
             //print_r($file);

             if ($file->saveAs($uploadPath . '/' . $file->name)) {
                 //Now save file data to database

                 echo \yii\helpers\Json::encode($file);
             }else{
                 return $this->render('index');
             }
         }

         return false;

     }*/
    public function actionUpload()
    {
        $fileName = 'file';
        $uploadPath = realpath(__DIR__ . '/../../../data/ticket/temp') ;
        var_dump($uploadPath);die();
        if (!file_exists($uploadPath))
        {
            mkdir($uploadPath, 0777, true);
            chmod($uploadPath, 0777);
        }
        $uploadPath = $uploadPath . '/';
        if (!file_exists($uploadPath))
        {
            mkdir($uploadPath, 0777, true);
            chmod($uploadPath, 0777);
        }

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            //Print file data
            //print_r($file);

            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                //Now save file data to database

                echo \yii\helpers\Json::encode($file);
            }
        }
        return false;
    }
}
