<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 30.05.16
 * Time: 10:21
 */
namespace app\controllers;

use app\models\LoginForm;
use app\models\SupportTicketComment;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\components\AccessRule;
use app\models\SupportTicket;
use yii\helpers\Url;



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
                        'actions' => ['index', 'submit-request', 'upload', 'us', 'create', 'ticket', 'complete', 'cancel', 'develop'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'submit-request', 'upload', 'us', 'create', 'ticket', 'complete', 'cancel', 'develop'],
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
                            'create'         => ['get', 'post'],
                            'ticket'         => ['get', 'post'],
                            'complete'       => ['get', 'post'],
                            'cancel'         => ['get', 'post'],
                            'develop'        => ['get', 'post']
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

                /** @var  $userticket User */
                $userticket = User::findOne(['email' => $model->email]);

                if ($userticket == null) {
                    //no login user
                    $guest = new User();
                    $guest->password = User::generatePassword();
                    $guest->email = $model->email;
                    $guest->role = User::ROLE_GUEST;
                    $guest->first_name = 'GUEST';
                    $guest->last_name = 'GUEST';

                    if ($guest->validate()) {
                        $guest->save();
                        $model->client_id = Yii::$app->user->id;
                        $model->status = SupportTicket::STATUS_NEW;
                        $model->is_private = 1;
                        $model->date_added = date('Y-m-d H:i:s');
                        if ($model->validate()) {

                            $model->save();
                            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                                'name' => 'ticket',
                                'value' => $model->id,

                            ]));
                            Yii::$app->mailer->compose()
                                ->setFrom(Yii::$app->params['adminEmail'])
                                ->setTo(Yii::$app->params['adminEmail'])
                                ->setSubject('New ticket' . $model->id)
                                ->send();
                            Yii::$app->mailer->compose()
                                ->setFrom(Yii::$app->params['adminEmail'])
                                ->setTo('valeriya@skynix.co')
                                ->setSubject('You Skynix ticket ' . $model->id)
                                ->send();
                            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, our team will review your request and get back to you soon!"));


                            return $this->redirect (['ticket', 'id' => $model->id]);

                        }
                    }
                } else {
                    if ($userticket != null && $userticket->is_delete == 1) {

                        $userticket->is_delete = 0;
                        $userticket->is_active = 0;
                        $userticket->invite_hash = md5(time());
                        $userticket->password = User::generatePassword();
                        $userticket->rawPassword = $userticket->password;
                        $userticket->password = md5($userticket->password);
                        $userticket->date_signup = date('Y-m-d H:i:s');
                        $userticket->save();
                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, our team will review your request and get back to you soon!"));
                        return $this->redirect('index');
                    }
                    if (!empty($userticket) && $userticket->is_delete == 0 && $userticket->password == md5($model->password)) {

                        $login = new LoginForm();
                        $login->email = $userticket->email;
                        $login->password = $userticket->rawPassword;
                        $login->login();
                    } else {
                        Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, but you entered a wrong password of your account"));
                        return $this->redirect('submit-request');
                    }
                }

            if(!Yii::$app->request->isGet){
                // user is not a guest
                $model->status = SupportTicket::STATUS_NEW;
                $model->is_private = 1;
                $model->date_added = date('Y-m-d H:i:s');
                $model->client_id = Yii::$app->user->id;
                if ($model->validate()) {

                    $model->save();
                    Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo(Yii::$app->params['adminEmail'])
                        ->setSubject('New ticket' . $model->id)
                        ->send();
                    Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo(User::findOne($model->client_id)->email)
                        ->setSubject('You Skynix ticket ' . $model->id)
                        ->send();
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, our team will review your request and get back to you soon!"));

                    return $this->redirect (['ticket', 'id' => $model->id]);


                }
            }
        }
    }
    public function actionTicket()
    {
        /** @var  $model SupportTicket*/
        if (($idTicket = Yii::$app->request->get('id')) && ($model = SupportTicket::findOne($idTicket)) != null) {
            if($model->is_private == 1  ){
                if(((isset(Yii::$app->user->identity->role) && User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM ]) ||
                    (isset($model->client_id) && $model->client_id == Yii::$app->user->id))) ||  Yii::$app->request->cookies['ticket']){
                    Yii::$app->response->cookies->remove('ticket');
                    if($model->load(Yii::$app->request->post())) {
                        $modelComment = new SupportTicketComment();
                        $modelComment->comment = $model->comment;
                        $modelComment->date_added = date('Y-m-d H:i:s');
                        $modelComment->user_id = Yii::$app->user->id;
                        $modelComment->support_ticket_id = $model->id;
                        if($modelComment->validate()){
                            $modelComment->save();

                            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, you add comment"));
                            //$model->comment = null;
                            return $this->refresh();
                        }
                    }
                    return $this->render('ticket', ['model' => $model]);

                }else{
                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, You cannot see this ticket. Please, sign in"));
                    return $this->redirect('submit-request');
                   // return $this->redirect(['/site/login']);

                }
            }else{
                if($model->load(Yii::$app->request->post())) {

                    $modelComment = new SupportTicketComment();
                    $modelComment->comment = $model->comment;
                    $modelComment->date_added = date('Y-m-d H:i:s');
                    $modelComment->user_id = Yii::$app->user->id;
                    $modelComment->support_ticket_id = $model->id;
                    if($modelComment->validate()){
                        $modelComment->save();


                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, you add comment"));
                        //$model->comment = null;
                        return $this->refresh();
                    }
                }
                return $this->render('ticket', ['model' => $model]);

            }
        }

    }
    public function actionComplete()
    {
        if ((Yii::$app->request->isAjax &&
            Yii::$app->request->isGet &&
            ($id = Yii::$app->request->get('ticket')) )
        ) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            /** @var $status SupportTicket */
            if($status = SupportTicket::findOne($id)){
                $status->status = SupportTicket::STATUS_COMPLETED;
                $status->date_completed = date('Y-m-d H:i:s');
                if($status->validate() && $status->save()){
                    //return $this->refresh();
                   /* Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo(User::findOne($status->assignet_to)->email)
                        ->setSubject('New ticket' . $status->id)
                        ->send();*/
                    Yii::$app->mailer->compose("newTicket", [
                        "ticket"    =>  $id,
                        "id"        =>  $status->id
                    ])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo(User::findOne($status->assignet_to)->email)
                        ->setSubject(('You Skynix ticket ' . $status->id))
                        ->send();

                    return [
                        "success" => true,
                        "date" => $status->date_completed
                    ];
                }else{
                    return[
                        "success" =>false,
                    ];
                }
            }
        }

    }
    public function actionCancel()
    {
        if ((Yii::$app->request->isAjax &&
            Yii::$app->request->isGet &&
            ($data = Yii::$app->request->get('query')))
        ) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            /** @var $status SupportTicket */
            if($status = SupportTicket::findOne($data)){
                $status->status = SupportTicket::STATUS_CANCELLED;
                if($status->validate() && $status->save()){
                    //return $this->refresh();
                    Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo(User::findOne($status->assignet_to)->email)
                        ->setSubject('New ticket' . $status->id)
                        ->send();
                    Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo(User::findOne($status->client_id)->email)
                        ->setSubject('You Skynix ticket ' . $status->id)
                        ->send();
                    return [
                        "success" => true,
                    ];
                }else{
                    return[
                        "success" =>false,
                    ];
                }
            }
        }

    }
    public function actionDevelop()
    {
        if ((Yii::$app->request->isAjax &&
            Yii::$app->request->isGet &&
            ($data = Yii::$app->request->get('query')))
        ) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if($modelDev = SupportTicket::findOne(Yii::$app->request->get('ticket'))){
                $modelDev->status = SupportTicket::STATUS_ASSIGNED;
                $modelDev->assignet_to = $data;
                if ($modelDev->validate()) {
                    $modelDev->save();
                    return [
                        "success" => true,
                    ];
                }else{
                    return[
                        "success" =>false,
                    ];
                }

            }

        }
    }
}
