<?php

namespace app\controllers;

use Yii;
use app\models\SupportTicket;
use app\models\Survey;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\components\Language;
use app\models\Upload;
use yii\web\UploadedFile;
use app\modules\api\models\ApiAccessToken;
use app\models\Career;

class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
            /*'error' => [
                'class' => 'yii\web\ErrorAction',

            ],*/
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionError()
    {
        return $this->render('error');
    }
    public function beforeAction($action)
    {

        $this->layout = "main";
        //var_dump( $this->layout); exit;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if ( !Yii::$app->user->isGuest ) {

            return $this->redirect(['cp/default/index']);

        }
        return $this->redirect( Yii::$app->params['url_site'] );
    }

    /** New or invited user login  */
    public function actionLogin()
    {

        $model = new LoginForm();
        /** Put the user's mail input if mail is not empty */
        if (($email = Yii::$app->request->get('email'))) {

            $model->email = $email;
            if (($password = Yii::$app->request->get('password'))) {

                $model->password = $password;

                if (($ticket = Yii::$app->request->get('id'))) {

                    if ($model->login()) {
                        return $this->redirect(['support/ticket', 'id' => $ticket]);
                    }
                    //$model->password = $password;

                }
            }

        }
        if ( $model->load(Yii::$app->request->post()) ) {

            // check for crowd session before access
            $checkUser = Yii::$app->crowdComponent->checkByEmailPasswordCRM($model->email, $model->password);
            if(isset($checkUser['error'])){
                Yii::$app->getSession()->setFlash('error', Yii::t("app", $checkUser['error']));
            }

            /** @var $user User */
            if( (($user = User::findOne(['email' => $model->email]) ) && md5($model->password) == $user->password) || ($checkUser === true)) {
                $modelUserLogins = User::find()
                    ->where('email=:Email',
                        [
                            ':Email' => $model->getUser()->email
                        ])
                    ->one();
                if ($modelUserLogins->role == User::ROLE_GUEST ) {
                    if($modelUserLogins->is_active == 1) {
                        if ($model->loginNoActive()) {

                            if (User::hasPermission([User::ROLE_GUEST])) {

                                    if ($modelUserLogins->date_login == null && $user->is_active == 0) {

                                        Yii::$app->getSession()->setFlash('success',
                                            Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
                                    } else {

                                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "Welcome to Skynix CRM"));

                                    }
                                    $modelUserLogins->date_login = date('Y-m-d H:i:s');
                                    $modelUserLogins->save();

                                    if (($id = Yii::$app->request->get('id'))) {

                                        return $this->redirect(["support/ticket", 'id' => $id]);
                                    } else {

                                        /** @var $quest SupportTicket */
                                        $ticket = SupportTicket::lastTicket($modelUserLogins->id);
                                        //exit();
                                        return $this->redirect(["support/ticket", 'id' => $ticket]);
                                    }
                            }
                            $modelUserLogins->date_login = date('Y-m-d H:i:s');
                            $modelUserLogins->save();
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('success',
                            Yii::t("app", "Please, activate your account through a confirm email link."));
                        return $this->redirect(["site/index"]);
                    }
                } else {

                    if ($model->login()) {

                        /** Save date login when user login */
                        /** @var $modelUserLogins User */
                        if (User::hasPermission([User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM])) {
                            if ($modelUserLogins->date_login == null) {

                                //$modelUserLogins->date_signup = date('Y-m-d H:i:s');
                                Yii::$app->getSession()->setFlash('success',
                                    Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
                            } else {

                                Yii::$app->getSession()->setFlash('success', Yii::t("app", "Welcome to Skynix CRM"));

                            }

                            $modelUserLogins->date_login = date('Y-m-d H:i:s');
                            $modelUserLogins->save();
                            if(($idticket = Yii::$app->request->get('ticket'))){

                                return $this->redirect(["support/ticket", 'id' => $idticket]);

                            }else {
                                    return $this->redirect(['cp/index/index']);
                            }
                        }

                        if (User::hasPermission([User::ROLE_SALES])) {
                            if ($modelUserLogins->date_login == null) {

                                //$modelUserLogins->date_signup = date('Y-m-d H:i:s');
                                Yii::$app->getSession()->setFlash('success',
                                    Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
                            } else {

                                Yii::$app->getSession()->setFlash('success', Yii::t("app", "Welcome to Skynix CRM"));

                            }

                            $modelUserLogins->date_login = date('Y-m-d H:i:s');
                            $modelUserLogins->save();
                            if(($idticket = Yii::$app->request->get('ticket'))){

                                return $this->redirect(["support/ticket", 'id' => $idticket]);

                            }else {
                                return $this->redirect(['cp/user/index']);
                            }
                        }

                        if (User::hasPermission([User::ROLE_CLIENT, User::ROLE_FIN])) {
                            if ($modelUserLogins->date_login == null) {

                                Yii::$app->getSession()->setFlash('success',
                                    Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
                            } else {

                                Yii::$app->getSession()->setFlash('success', Yii::t("app", "Welcome to Skynix CRM"));

                            }
                            $modelUserLogins->date_login = date('Y-m-d H:i:s');
                            $modelUserLogins->save();
                            return $this->redirect(['cp/user/index']);
                        }
                        $modelUserLogins->date_login = date('Y-m-d H:i:s');
                        $modelUserLogins->save();

                    } else {

                        Yii::$app->getSession()->setFlash('error', Yii::t("app", "No user is registered on this email"));
                        return $this->refresh();
                    }
                }
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t("app", "Entered Email address or password is incorrect"));
                return $this->refresh();
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    public function actionLoginByAccessToken()
    {
        if ( ($accessToken = Yii::$app->request->get('accessToken')) &&
            ( $apiAccessTokenModel = ApiAccessToken::findIdentityByAccessToken( $accessToken ) ) &&
                $apiAccessTokenModel->isAccessTokenValid() &&
            ( $user = User::findOne($apiAccessTokenModel->user_id) ) &&
            $user->is_active == User::ACTIVE_USERS &&
            $user->is_delete != User::DELETED_USERS ) {
            
            Yii::$app->user->login( $user );
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Welcome to Skynix CRM"));

            return $this->redirect(['cp/default/index']);
            
        }
        Yii::$app->getSession()->setFlash('error', Yii::t("app", "Wrong Access Token"));
        return $this->redirect(['site/index']);
    }

    /** Log out user*/
    public function actionLogout()
    {
        $path = "/";
        $domain = ".skynix.co";
        Yii::$app->user->logout();
        setcookie(User::CREATE_COOKIE_NAME,"",time()-3600*60, $path, $domain);
        setcookie(User::COOKIE_DATABASE,"",time()-3600*60, $path, $domain);
        return $this->redirect( "/" );
    }

    /**
     * @deprecated 
     * @return string|Response
     */
    public function actionContact()
    {
        return $this->redirect( Yii::$app->params['url_site'] . '/contacts');
    }

    /**
     * @deprecated 
     * @return string
     */
    public function actionCareer()
    {
        return $this->redirect( Yii::$app->params['url_site'] . '/careers');
    }

    /**
     * @deprecated 
     * @return string
     */
    public function actionPrivacy()
    {
        return $this->redirect( Yii::$app->params['url_site'] . '/privacy-policy');
    }

    /**
     * @deprecated  
     * Invited user activated */
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
    /**
     * @deprecated 
     * pass the post option, and send a letter request */
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

    /**
     * @deprecated 
     * @param $shortcode
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionSurvey($shortcode)
    {
        /** @var  $model Survey*/
        $model = Survey::find()
                        ->where(['shortcode' => $shortcode])
                        ->one();

            if ($model != null) {

                    if ( $model->is_private == 1 && Yii::$app->user->isGuest ) {

                        Yii::$app->getSession()->setFlash("error", "It is Skynix internal survey. Please login and get back to the survey.");
                        return $this->redirect(['login']);

                    } else {

                        if ( $model->isLive() ) {

                            return $this->render('survey', [
                                'model' => $model,
                            ]);

                        } else {

                            $now = strtotime('now');

                            if ( $now < strtotime( $model->date_start ) ) {

                                return $this->render('survey-coming', [
                                    'model' => $model,
                                ]);

                            } else {

                                return $this->render('survey-results', [
                                    'model' => $model,
                                ]);

                            }

                        }

                    }

            }else{

                throw new NotFoundHttpException('The survey has not been found');

            }
    }

    /**
     * @deprecated 
     * @throws \yii\base\ExitException
     */
    public function actionSubmitSurvey()
    {
        $data = ['success' => false];
        /** @var $survey Model Survey */
        if ( ($id           = Yii::$app->request->post('id')) &&
            ( $surveyModel  = Survey::findOne($id) ) &&
            ( $answer       = Yii::$app->request->post('answer')) &&
            $surveyModel->isLive() &&
            $surveyModel->canVote()
            ) {

            $surveyModel->vote( $answer );
            $data['success'] = true;
            $data['message'] = Yii::t('app', 'Your vote has been submitted. Thank You for your effort!');

        } elseif ( $surveyModel ) {

            $data['message'] = Yii::t('app', 'Your vote has not been calculated. This seems you have already took a part in this survey.');

        } else {

            $data['message'] = Yii::t('app', 'You can not participate this survey');

        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content = json_encode($data);
        Yii::$app->end();
    }

    public function actionStatus()
    {
        $f = Career::find()->all();
        return $this->render('for_status', ['f' => $f]);
    }

}