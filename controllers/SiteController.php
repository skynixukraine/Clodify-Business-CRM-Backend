<?php

namespace app\controllers;

use app\components\Bootstrap;
use app\models\CoreClient;
use app\models\CoreClientOrder;
use app\models\SalaryReportList;
use app\models\Setting;
use Yii;
use app\models\SupportTicket;
use app\models\Survey;
use yii\filters\AccessControl;
use yii\log\Logger;
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
        return $this->render('index');
        //return $this->redirect( Yii::$app->params['url_site'] );
    }

    /** New or invited user login  */
    public function actionLogin()
    {

        return $this->redirect(Yii::$app->params['url_crm_app']);
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
        $f = User::find()->one();
        return $this->render('for_status', ['f' => $f]);
    }

    public function actionTest500()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->getResponse()->setStatusCode(500);
        Yii::$app->response->content = '{"data":null,"errors":{"param":"error","message":"An internal server error occurred.","trace":[]},"success":false}';
        Yii::$app->end();
    }

    public function actionChecksso()
    {


        if ( ($domain = str_replace(".", "_", Setting::getSSOCookieDomain()) ) &&
            isset($_COOKIE[$domain]) &&
            ($keyValue = $_COOKIE[$domain]) &&
            ($response = Yii::$app->crowdComponent->validateCrowdSession( $keyValue )) &&
            $response['success'] === true) {

            if ( ($accessToken = ApiAccessToken::findIdentityByCrowdToken($keyValue) ) ) {

                $accessToken->crowd_exp_date = $response['expiryDate'];
                $accessToken->save(false, ['crowd_exp_date']);

            } else if ( !empty($response['user']['name']) &&
                ($user = User::findByEmail($response['user']['name'])) &&
                ($user->is_delete = 0 ) &&
                ($user->is_active = 1) ) {

                $accessToken = ApiAccessToken::generateNewToken( $user );
                $accessToken->crowd_token       = $keyValue;
                $accessToken->crowd_exp_date    = $response['expiryDate'];
                $accessToken->save(false, ['crowd_token', 'crowd_exp_date']);

            }
            if ( $accessToken && ($user = User::findOne( $accessToken->user_id ))) {

                Yii::$app->request->cookies->offsetSet('skynix-access-token', $accessToken->access_token);
                Yii::$app->request->cookies->offsetSet('skynix-userId', $user->id);
                Yii::$app->request->cookies->offsetSet('skynix-role', $user->role);
            }


        }
        return $this->redirect( Yii::$app->params['url_crm_app'] . '/login' );
    }

    public function actionTestorder()
    {
        return $this->render('testorder');
    }

    public function actionTest()
    {
        echo SalaryReportList::getNumNonApprovedHoursInMonthDuringWorkingDays(10, 1541023200);
        die();
    }

    public function actionPaymentCallback()
    {
        Yii::getLogger()->log("PaymentCallback", Logger::LEVEL_INFO);
        $domain = null;
        if ( ( $payment = Yii::$app->request->post('payment') ) &&
            ( $signature = Yii::$app->request->post('signature') ) ) {

            Yii::getLogger()->log($payment, Logger::LEVEL_INFO);

            if ( ($sign = sha1 (md5($payment.Yii::$app->params['merchantPassword']))) === $signature ) {

                $orderId    = null;
                $state      = null;
                $ref        = null;
                foreach (explode('&', $payment) as $chunk) {
                    $param = explode("=", $chunk);

                    if ($param && $param[0] === "order") {

                        $orderId = $param[1];

                    } else if ($param && $param[0] === "state") {

                        $state = $param[1];

                    } else if ($param && $param[0] === "ref") {

                        $ref = $param[1];

                    }
                }
                if ( $orderId > 0 ) {
                    /** @var CoreClientOrder */
                    if ( ($clientOrder = CoreClientOrder::findOne($orderId))) {

                        if ( $state === 1 || $state === "test") {

                            $clientOrder->status    = CoreClientOrder::STATUS_PAID;
                            $clientOrder->paid      = date('Y-m-d');

                        } else {

                            $clientOrder->status    = CoreClientOrder::STATUS_CANCELED;

                        }
                        $clientOrder->ref       = $ref;
                        $clientOrder->payment   = $payment;
                        $clientOrder->save(false, ['status', 'payment', 'paid', 'ref']);

                        /** @var $client CoreClient */
                        if ( ($client = CoreClient::findOne($clientOrder->client_id))) {

                            if ( $clientOrder->status === CoreClientOrder::STATUS_PAID ) {

                                $client->prepaid_for = date('Y-m-d', strtotime('now +1 month'));
                                $client->save(false, ['prepaid_for']);

                            }

                        }

                    } else {

                        Yii::getLogger()->log("Merchant Order is not found !!!", Logger::LEVEL_WARNING);

                    }

                } else {

                    Yii::getLogger()->log("Merchant Order ID is not present!!!", Logger::LEVEL_WARNING);

                }

            } else {

                Yii::getLogger()->log("Merchant signature is wrong!!!", Logger::LEVEL_WARNING);
                Yii::getLogger()->log($signature, Logger::LEVEL_WARNING);
                Yii::getLogger()->log($sign, Logger::LEVEL_WARNING);

            }

        } else {

            Yii::getLogger()->log("Merchant data is blank!!!! " . Yii::$app->request->getRawBody(), Logger::LEVEL_WARNING);

        }

    }

    public function actionPaymentStatus()
    {
        Yii::getLogger()->log("PaymentStatus", Logger::LEVEL_INFO);
        $domain = null;
        if ( ( $payment = Yii::$app->request->post('payment') ) &&
            ( $signature = Yii::$app->request->post('signature') ) ) {

            Yii::getLogger()->log($payment, Logger::LEVEL_INFO);

            if ( ($sign = sha1 (md5($payment.Yii::$app->params['merchantPassword']))) === $signature ) {

                $orderId = null;
                $state   = null;
                $ref     = null;
                foreach (explode('&', $payment) as $chunk) {
                    $param = explode("=", $chunk);

                    if ($param && $param[0] === "order") {

                        $orderId = $param[1];

                    } else if ($param && $param[0] === "state") {

                        $state = $param[1];

                    } else if ($param && $param[0] === "ref") {

                        $ref = $param[1];

                    }
                }
                if ( $orderId > 0 ) {
                    /** @var CoreClientOrder */
                    if ( ($clientOrder = CoreClientOrder::findOne($orderId))) {

                        if ( $state === 1 || $state === "test") {

                            $clientOrder->status    = CoreClientOrder::STATUS_PAID;
                            $clientOrder->paid      = date('Y-m-d');

                        } else {

                            $clientOrder->status    = CoreClientOrder::STATUS_CANCELED;

                        }
                        $clientOrder->ref       = $ref;
                        $clientOrder->payment   = $payment;
                        $clientOrder->save(false, ['status', 'payment', 'paid', 'ref']);

                        /** @var $client CoreClient */
                        if ( ($client = CoreClient::findOne($clientOrder->client_id))) {

                            $domain = $client->getUnConvertedDomain();
                            if ( $clientOrder->status === CoreClientOrder::STATUS_PAID ) {

                                $client->prepaid_for = date('Y-m-d', strtotime('now +1 month'));
                                $client->save(false, ['prepaid_for']);

                            }

                        }

                    } else {

                        Yii::getLogger()->log("Merchant Order is not found !!!", Logger::LEVEL_WARNING);

                    }

                } else {

                    Yii::getLogger()->log("Merchant Order ID is not present!!!", Logger::LEVEL_WARNING);

                }

            } else {

                Yii::getLogger()->log("Merchant signature is wrong!!!", Logger::LEVEL_WARNING);
                Yii::getLogger()->log($signature, Logger::LEVEL_WARNING);
                Yii::getLogger()->log($sign, Logger::LEVEL_WARNING);

            }

        } else {

            Yii::getLogger()->log("Merchant data is blank!!!! " . Yii::$app->request->getRawBody(), Logger::LEVEL_WARNING);

        }


        $baseDomain = str_replace('https://', '', Yii::$app->params['url_crm_app']);
        Yii::$app
            ->response
            ->redirect("https://" . Yii::$app->env->getEnv() .
                (Yii::$app->env->getClientDomain() ? "." . Yii::$app->env->getClientDomain()  : "" ) . "." . $baseDomain . "/payment-status");
        Yii::$app->response->send();
    }

}