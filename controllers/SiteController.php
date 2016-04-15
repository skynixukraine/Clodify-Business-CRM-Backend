<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\components\Language;
use app\models\Upload;
use yii\web\UploadedFile;


class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'request'],
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
    public function beforeAction($action)
    {

        if ( ( $url = Language::getRedirectUrl() ) ) {

            $this->redirect($url);

        }

        $this->layout = "main_" . Language::getLanguage();
        //var_dump( $this->layout); exit;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        /*if ( !Yii::$app->user->isGuest ) {

            return $this->redirect(['cp/index']);

        }*/
        return $this->render('index_' . Language::getLanguage() );
    }

    /** New or invited user login  */
    public function actionLogin()
    {

        $model = new LoginForm();
        /** Put the user's mail input if mail is not empty */
        if (($email = Yii::$app->request->get('email'))) {

            $model->email = $email;

        }
        if ( $model->load(Yii::$app->request->post()) ) {

            if ($model->login()) {

                /** Save date login when user login */
                /** @var $modelUserLogins User */
                $modelUserLogins = User::find()
                    ->where('email=:Email',
                        [
                            ':Email' => $model->getUser()->email
                        ])
                    ->one();

                $modelUserLogins->date_login = date('Y-m-d H:i:s');

                $modelUserLogins->save(true, ['date_login']);
                if ( User::hasPermission([User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM])) {
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
                    return $this->redirect( Language::getDefaultUrl() . '/cp/index');
                }
                if ( User::hasPermission([User::ROLE_CLIENT, User::ROLE_FIN])){
                    Yii::$app->getSession()->setFlash('success',
                        Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
                    return $this->redirect( Language::getDefaultUrl() . '/cp/user/index');
                }

            } else {

                Yii::$app->getSession()->setFlash('error', Yii::t("app", "No user is registered on this email"));
                /*return $this->render('login', ['model' => $model]);*/
                return $this->refresh();
            }
        }
        return $this->render('login_' . Language::getLanguage() , ['model' => $model]);
    }

    /** Log out user*/
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect( Language::getUrl() );
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact_' . Language::getLanguage() , [
            'model' => $model,
        ]);
    }

    public function actionCareer()
    {
        return $this->render('career_' . Language::getLanguage());
    }

    public function actionPrivacy()
    {
        return $this->render('privacy_' . Language::getLanguage());
    }

    /** Invited user activated */
    public function actionInvite( $hash )
    {
        /** @var  $model User */
        if( ($model = User::find()
                ->where('invite_hash=:hash',
                    [
                        ':hash' => $hash
                    ])->one())) {

            $model->is_active = 1;
            $model->invite_hash = null;
            $model->date_signup = date('Y-m-d H:i:s');
            $model->save();
            if( Yii::$app->user->id != null ){

                Yii::$app->user->logout();
            }
            Yii::$app->getSession()->setFlash('success',
            Yii::t("app", "Welcome to Skynix, you have successfully activated your account", false));
            return $this->redirect(['site/login', 'email'=>$model->email]);

        }else {
            if( Yii::$app->user->id != null ){

                Yii::$app->user->logout();

            }
            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, but this link is expired.
            Please contact administrator if you wish to activate your account"));
        }
        return $this->redirect(['site/index']);
    }
    /* pass the post option, and send a letter request */
    public function actionRequest()
    {
        $model = new Upload();


        if ( Yii::$app->request->isAjax &&
             Yii::$app->request->isPost ) {

            $websiteState   = Yii::$app->request->post('website_state');
            $platform       = Yii::$app->request->post('platform');
            $services       = Yii::$app->request->post('services');
            $frontendPlatform   = Yii::$app->request->post('frontend_platform');
            $backendPlatform    = Yii::$app->request->post('backend_platform');
            $whenStart      = Yii::$app->request->post('when_start');
            $budget         = Yii::$app->request->post('budget');
            $description    = Yii::$app->request->post('description');
            $name           = Yii::$app->request->post('name');
            $email          = Yii::$app->request->post('email');
            $company        = Yii::$app->request->post('company');
            $country        = Yii::$app->request->post('country');
            $model->file    = UploadedFile::getInstance($model, 'file');

                $message = Yii::$app->mailer->compose('request', [
                    'name'          => $name,
                    'websiteState'  => $websiteState,
                    'platform'      => $platform,
                    'services'      => $services,
                    'frontendPlatform'  => $frontendPlatform,
                    'backendPlatform'   => $backendPlatform,
                    'whenStart'         => $whenStart,
                    'budget'            => $budget,
                    'description'       => $description,
                    'email'             => $email,
                    'company'           => $company,
                    'country'           => $country

                ])
                    ->setFrom(Yii::$app->params['adminEmail'] )
                    ->setTo( Yii::$app->params['adminEmail'] )
                    ->setReplyTo( [ $email => $name ] )
                    ->setSubject('Skynix - New quote. Requested by ' . $name);

                    if ($model->upload()) {

                         $message->attach( Yii::getAlias('@app/data/documents/' . $model->fileName ) );

                    }
                    $message->send();

                 $response = Yii::$app->response;
                 $response->getHeaders()->set('Vary', 'Accept');
                 $response->format = Response::FORMAT_JSON;

                echo json_encode([
                    "success" => true
                ]);
            }

        else{

                echo json_encode([
                    "success" => false
                ]);
        }


    }
}
