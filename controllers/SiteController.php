<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\components\Language;

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

            return $this->redirect($url);

        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if ( !Yii::$app->user->isGuest ) {

            return $this->redirect(['cp/index']);

        }
        return $this->render('index');
    }

    /** New or invited user login  */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        /** Put the user's mail input if mail is not empty */
        if (($email = Yii::$app->request->get('email'))) {

            $model->email = $email;

        }
        if ( $model->load(Yii::$app->request->post()) ) {

            if ($model->login()) {


                /** Save date login when user login */
                $modelUserLogins = User::find()
                    ->where('email=:Email',
                        [
                            ':Email' => $model->getUser()->email
                        ])
                    ->one();
                /** @var $modelUserLogins User */
                //var_dump($modelUserLogins->date_login);
                //var_dump($modelUserLogins->date_singup);
                //exit();
                $modelUserLogins->date_login = date('Y-m-d H:i:s');
                /*var_dump($modelUserLogins->date_login);
                exit();*/
                $modelUserLogins->save(true, ['date_login']);
                if ( User::hasPermission([User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM])) {

                    return $this->redirect( Language::getDefaultUrl() . '/cp/index');
                }
                if ( User::hasPermission([User::ROLE_CLIENT, User::ROLE_FIN])){

                    return $this->redirect( Language::getDefaultUrl() . '/cp/user/index');
                }

            } else {

                Yii::$app->getSession()->setFlash('error', Yii::t("app", "No user is registered on this email"));
                return $this->render('login', ['model' => $model]);
            }
        }
        return $this->render('login', ['model' => $model]);
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
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
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
            Yii::t("app", "Welcome to Skynix, you have successfully activated your account"));
            return $this->redirect(['/site/login', 'email'=>$model->email]);

        }else {
            if( Yii::$app->user->id != null ){

                Yii::$app->user->logout();

            }
            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, but this link is expired.
            Please contact administrator if you wish to activate your account"));
        }
        return $this->redirect(['/site/index']);
    }
}
