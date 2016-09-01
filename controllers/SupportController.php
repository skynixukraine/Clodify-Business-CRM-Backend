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
                'rules' => [
                    [
                        'actions' => ['index', 'submit-request', 'upload', 'us', 'create', 'ticket', 'complete', 'cancel', 'develop', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'submit-request', 'upload', 'us', 'create', 'ticket', 'complete', 'cancel', 'develop', 'login'],
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
                            'develop'        => ['get', 'post'],
                            'login'          => ['get', 'post']
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
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'subject',
                    'value' => $data,

                ]));

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
        if(Yii::$app->request->cookies['subject']){
            $model->subject = Yii::$app->request->cookies['subject'];
        }
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

            if( User::findOne(['email' => $data, 'is_delete'=> 0]) != null ) {

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
                    $model->status = SupportTicket::STATUS_NEW;
                    $model->is_private = 1;
                    $model->date_added = date('Y-m-d H:i:s');
                    if($model->validate()) {

                        $model->save();
                    }
                    //no login user
                    $guest = new User();
                    $guest->password = User::generatePassword();
                    $guest->email = $model->email;
                    $guest->role = User::ROLE_GUEST;
                    $guest->first_name = 'GUEST';
                    $guest->last_name = 'GUEST';
                    $guest->ticketId = $model->id;

                    if ($guest->validate()) {

                            $guest->save();

                        $model->client_id = $guest->id;

                        if ($model->validate()) {

                            $model->save();

                           /* Yii::$app->response->cookies->add(new \yii\web\Cookie([
                                'name' => 'ticket',
                                'value' => $model->id,

                            ]));*/
                            Yii::$app->mailer->compose("ticket", [
                                "id"        =>  $model->id
                            ])
                                ->setFrom(Yii::$app->params['adminEmail'])
                                ->setTo(Yii::$app->params['adminEmail'])
                                ->setSubject('New ticket# ' . $model->id)
                                ->send();
                            Yii::$app->mailer->htmlLayout = 'layouts/support';
                            Yii::$app->mailer->compose( "newTicket", [
                                "active"    => $guest->is_active,
                                "email"     => $guest->email,
                                "id"        => $model->id,
                                "username"  => $guest->first_name,
                                "subject"   => $model->subject
                            ])
                                ->setFrom(Yii::$app->params['adminEmail'])
                                ->setTo(User::ClientTo($model->id))
                                ->setSubject('Your support ticket #' . $model->id . ' ' . ' is opened')
                                ->send();
                            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, our team will review
                            your request and get back to you soon! Please, activate your account through a confirm email link."));
                            return $this-> redirect(['site/index']);
                        }
                    }
                } else {
                    if ($userticket != null && $userticket->is_delete == 1) {

                        $model->status = SupportTicket::STATUS_NEW;
                        $model->is_private = 1;
                        $model->date_added = date('Y-m-d H:i:s');
                        /* add new ticket*/
                        if($model->validate()) {

                            $model->save();
                        }
                        $userticket->is_delete = 0;
                        $userticket->is_active = 0;
                        $userticket->invite_hash = md5(time());
                        $userticket->password = User::generatePassword();
                        $userticket->rawPassword = $userticket->password;
                        $userticket->password = md5($userticket->password);
                        $userticket->date_signup = date('Y-m-d H:i:s');
                        $userticket->ticketId = $model->id;
                        $userticket->save();

                        $model->client_id = $userticket->id;

                        if ($model->validate()) {

                            $model->save(true, ['client_id']);
                        }
                        Yii::$app->response->cookies->add(new \yii\web\Cookie([
                            'name' => 'ticket',
                            'value' => $model->id,

                        ]));

                        Yii::$app->mailer->compose("ticket", [
                            "id"        =>  $model->id
                        ])
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setTo(Yii::$app->params['adminEmail'])
                            ->setSubject('New ticket# ' . $model->id)
                            ->send();

                        Yii::$app->mailer->htmlLayout = 'layouts/support';
                        Yii::$app->mailer->compose("newTicket", [
                            "active"    => $userticket->is_active,
                            "email"     => $userticket->email,
                            "id"        => $userticket->id,
                            "username"  => $userticket->first_name,
                            "subject"   => $model->subject
                        ])
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setTo(User::ClientTo($model->id))
                            ->setSubject('Your support ticket #' . $model->id . ' ' . ' is opened')
                            ->send();
                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, our team will review your request and get back to you soon!"));


                        return $this->redirect (['ticket', 'id' => $model->id]);

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

                if(!Yii::$app->user->isGuest || ($userticket != null && $userticket->is_delete == 0 && $userticket->is_active == 1)){

                    if(Yii::$app->user->id == null) {
                        $login = new LoginForm();
                        $login->email = $model->email;
                        $login->loginNoActive();
                    }
                    //if($userticket->is_active == 1) {
                        // user is not a guest
                        $model->status = SupportTicket::STATUS_NEW;
                        $model->is_private = 1;
                        $model->date_added = date('Y-m-d H:i:s');
                        $model->client_id = Yii::$app->user->id;

                        if ($model->validate()) {

                            $model->save();

                            Yii::$app->mailer->compose("ticket", [
                                "id"        =>  $model->id
                            ])
                                ->setFrom(Yii::$app->params['adminEmail'])
                                ->setTo(Yii::$app->params['adminEmail'])
                                ->setSubject('New ticket #' . $model->id)
                                ->send();
                            $user = User::findOne($model->client_id);
                            Yii::$app->mailer->htmlLayout = 'layouts/support';
                            Yii::$app->mailer->compose("newTicket", [
                                "active"    => $user->is_active,
                                "email"     => $user->email,
                                "id"        =>  $model->id,
                                "username"  => $user->first_name,
                                "subject"   => $model->subject
                            ])
                                ->setFrom(Yii::$app->params['adminEmail'])
                                ->setTo(User::findOne($model->client_id)->email)
                                ->setSubject('Your support ticket #' . $model->id . ' ' . ' is opened')
                                ->send();
                            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, our team will review your request and get back to you soon!"));

                            return $this->redirect (['ticket', 'id' => $model->id]);
                        }

            } else {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t("app", "Thank You, our team will review your request and get back to you soon! Please, activate your account through a confirm email link."));
                    return $this->redirect(["site/index"]);
                }
        }
    }
    public function actionTicket()
    {
        /** @var  $model SupportTicket*/
        if(isset(Yii::$app->user->id)) {
            /** @var $user User */
            $user = User::findOne(Yii::$app->user->id);
            if (($idTicket = Yii::$app->request->get('id')) && ($model = SupportTicket::findOne($idTicket)) != null) {
                if ($model->is_private == 1) {
                    if (((isset(Yii::$app->user->identity->role) && User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM]) ||
                            (isset($model->client_id) && $model->client_id == Yii::$app->user->id))) || Yii::$app->request->cookies['ticket'] ||
                        (User::hasPermission([User::ROLE_DEV]) && $model->assignet_to == Yii::$app->user->id)
                    ) {

                        Yii::$app->response->cookies->remove('ticket');
                        if ($model->load(Yii::$app->request->post())) {
                            $modelComment = new SupportTicketComment();
                            $modelComment->comment = $model->comment;
                            $modelComment->date_added = date('Y-m-d H:i:s');
                            $modelComment->user_id = Yii::$app->user->id;
                            $modelComment->support_ticket_id = $model->id;
                            if ($modelComment->validate()) {
                                $modelComment->save();

                                Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, you add comment"));
                                return $this->refresh();
                            }
                        }

                        return $this->render('ticket', ['model' => $model]);

                    } elseif ($user->is_active == 0) {
                        Yii::$app->getSession()->setFlash('error', Yii::t("app", "You cannot see this ticket. Please, activate your account."));
                        return $this->redirect(['index']);

                    } else {
                        Yii::$app->getSession()->setFlash('error', Yii::t("app", "You cannot see this ticket. Please, log in."));
                        return $this->redirect(['index']);

                    }
                } else {
                    if ($model->load(Yii::$app->request->post())) {

                        $modelComment = new SupportTicketComment();
                        $modelComment->comment = $model->comment;
                        $modelComment->date_added = date('Y-m-d H:i:s');
                        $modelComment->user_id = Yii::$app->user->id;
                        $modelComment->support_ticket_id = $model->id;
                        if ($modelComment->validate()) {
                            $modelComment->save();
                            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You, you add comment"));
                            return $this->refresh();
                        }
                    }
                    return $this->render('ticket', ['model' => $model]);
                }
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t("app", "You cannot see this ticket. Please, log in."));
            return $this->redirect(['index']);
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
                    if($status->assignet_to != null){
                    Yii::$app->mailer->compose("ticket", [
                        "id"        =>  $status->id
                    ])
                        ->setFrom(User::findOne($status->assignet_to)->email)
                        ->setTo(Yii::$app->params['adminEmail'])
                        ->setSubject(('New ticket# ' . $status->id))
                        ->send();
                    }
                    Yii::$app->mailer->htmlLayout = 'layouts/support';
                    Yii::$app->mailer->compose("newTicket", [
                        "active"    => User::findOne($status->client_id)->is_active,
                        "email"     => User::findOne($status->client_id)->email,
                        "id"        =>  $status->id,
                        "username"  => User::findOne($status->client_id)->first_name,
                        "subject"   => $status->subject
                    ])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo(User::findOne($status->client_id)->email)
                        ->setSubject(('Your support ticket #' . $status->id . ' ' . ' is opened'))
                        ->send();

                    return [
                        "success" => true,
                        "date" =>  Yii::$app->formatter->asDatetime($status->date_completed, 'y-MM-d H:m')
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
                $status->date_cancelled = date('Y-m-d H:i:s');
                if($status->validate() && $status->save()){

                    if($status->assignet_to != null){
                        Yii::$app->mailer->compose("ticket", [
                            "id"        =>  $status->id
                        ])
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setTo(User::findOne($status->assignet_to)->email)
                            ->setSubject('New ticket# ' . $status->id)
                            ->send();
                        }
                        Yii::$app->mailer->htmlLayout = 'layouts/support';
                        Yii::$app->mailer->compose("newTicket", [
                            "active"    => User::findOne($status->client_id)->is_active,
                            "email"     => User::findOne($status->client_id)->email,
                            "id"        =>  $status->id,
                            "username"  => User::findOne($status->client_id)->first_name,
                            "subject"   => $status->subject
                        ])
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setTo(User::findOne($status->client_id)->email)
                            ->setSubject('Your support ticket #' . $status->id . ' ' . ' is opened')
                            ->send();
                        return [
                            "success" => true,
                            "date" =>  Yii::$app->formatter->asDatetime($status->date_cancelled, 'y-MM-d H:i')
                        ];
                } else {
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

                        Yii::$app->mailer->compose("ticket", [
                            "id"        =>  $modelDev->id
                        ])
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setTo(User::findOne($modelDev->assignet_to)->email)
                            ->setSubject(('New Ticket# ' . $modelDev->id))
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
    public function actionLogin()
    {
        $model = new LoginForm();
        /** Put the user's mail input if mail is not empty */
        if (($email = Yii::$app->request->get('email')) && ($id = Yii::$app->request->get('id'))) {
            /** @var  $user User*/
            if( $user = User::findOne(['email' => $email]) ) {

                if($user->invite_hash != null) {

                    $user->is_active = 1;
                    $user->invite_hash = null;

                    $user->save(true, ['is_active', 'invite_hash']);
                    if( Yii::$app->user->id != null ){

                        Yii::$app->user->logout();
                    }
                    if($user->is_active == 0) {

                        Yii::$app->getSession()->setFlash('success',
                            Yii::t("app", "Welcome to Skynix, you have successfully activated your account."));
                    }
                    $model->email = $email;
                    return $this->redirect(['site/login', 'email'=>$model->email, 'password'=>$model->password, 'id' => $id]);
                    /*if ($model->loginNoActive()) {
                        return $this->redirect(['ticket', 'id' => $id]);

                    }*/
                } else {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t("app", "You cannot see this ticket. Please, log in"));
                    return $this->redirect(["site/index"]);

                }

            }
        }
    }
}
