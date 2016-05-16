<?php

namespace app\controllers;

use app\models\Survey;
use app\models\SurveyVoter;
use app\models\SurveysOption;
use Faker\Provider\tr_TR\DateTime;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\components\Language;
use app\models\Upload;
use yii\web\UploadedFile;
use DateTimeInterface;

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

            if( md5($model->password) == User::findOne(['email' => $model->email])->password ){

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


                    if (User::hasPermission([User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM])) {
                        if($modelUserLogins->date_signup == null) {

                            $modelUserLogins->date_signup = date('Y-m-d H:i:s');
                            Yii::$app->getSession()->setFlash('success',
                                Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
                        }

                        $modelUserLogins->save();
                        return $this->redirect(Language::getDefaultUrl() . '/cp/index');
                    }
                    if (User::hasPermission([User::ROLE_CLIENT, User::ROLE_FIN])) {
                        if($modelUserLogins->date_signup == null) {

                            $modelUserLogins->date_signup = date('Y-m-d H:i:s');
                            Yii::$app->getSession()->setFlash('success',
                                Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
                        }
                        $modelUserLogins->save();
                        return $this->redirect(Language::getDefaultUrl() . '/cp/user/index');
                    }
                } else {

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "No user is registered on this email"));
                    return $this->refresh();
                }
            } else {

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Incorrect password"));
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

                        //var_dump(date("Y-m-d H:i:s", strtotime( $model->date_start )));
                        //var_dump(date("Y-m-d H:i:s", $now));
                        //exit;
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
        return $this->render('survey');
    }

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
       // \yii\helpers\VarDumper::dump( $_POST, 10, true);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content = json_encode($data);
        Yii::$app->end();
    }


}
