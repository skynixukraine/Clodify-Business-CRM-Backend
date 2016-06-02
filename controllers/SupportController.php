<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 30.05.16
 * Time: 10:21
 */
namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
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
                        'actions' => ['index', 'submit-request', 'upload', 'us', 'create'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'submit-request', 'upload', 'us', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
             'verbs' => [
                    'class' => VerbFilter::className(),
                        'actions' => [
                            'index'          => ['get', 'post'],
                            'submit-request' => ['get', 'post'],
                            'upload'         => ['get', 'post'],
                            'us'             => ['get', 'post'],
                            'create'         => ['get', 'post']
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

            }
            if (!isset($subjectId)) {
                return [
                    "error" => true
                ];
            } else {
                return $subjectId;

            }

        }

        return $this->render('index', ['model' => $model]);
    }

    public function actionSubmitRequest()
    {
        $model = new SupportTicket();
            //$model->email = Yii::$app->user->identity->email;

        return $this->render('submit-request', ['model' => $model]);
    }
    public function actionUs()
    {
        if ((Yii::$app->request->isAjax &&
            Yii::$app->request->isGet &&
            ($data = Yii::$app->request->get('query')))
        ) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if( User::findOne(['email' => $data, 'is_delete'=> 0, 'is_active'=> 1]) != null ) {
                return [
                    "success" => true
                ];
            } else {
                return [
                    "success" => false
                ];
            }


        }
    }

    public function actionUpload()
    {
        $fileName = 'file';
        $uploadPath = Yii::getAlias("@app") . "/data/ticket" ;
        //var_dump($uploadPath);die();
        if (!file_exists($uploadPath))
        {
            mkdir($uploadPath);
            chmod($uploadPath, 0777);
        }
        $uploadPath .= '/temp/';
        if (!file_exists($uploadPath))
        {
            mkdir($uploadPath);
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
    public function actionCreate()
    {
        $model = new SupportTicket();

        if($model->load(Yii::$app->request->post())) {


            $userticket = User::findOne(['email'=> $model->email]);

            if($userticket == null) {
                //no login user
                $guest = new User();
                $guest->password = User::generatePassword();
                $guest->email = $model->email;
                $guest->role = User::ROLE_GUEST;
                $guest->first_name = 'GUEST';
                $guest->last_name = 'GUEST';
                $guest->is_delete = 0;
                $guest->is_active = 0;
                $guest->invite_hash = md5(time());
                $guest->rawPassword = $guest->password;
                var_dump(md5($guest->password));die();
                $guest->password = md5($guest->password);
                $guest->date_signup = date('Y-m-d H:i:s');

                if($guest->validate() && $guest->save()){

                }
            } else {
                //login user
                if($userticket->password == md5($model->password)) {
                    //password right
                } else {
                    //no right
                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, but you entered a wrong password of your account"));
                    //return $this->redirect('index');
                    //exit();
                    return $this->redirect('submit-request');
                }
            }
        }
        /*if(Yii::$app->user->id == null){
            if ($model->validate()) {

                $model->save();


            }
        }*/
        //return $this->redirect('index', ['model' => $model]);
    }
}
