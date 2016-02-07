<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

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

    public function actionIndex()
    {
        if ( !Yii::$app->user->isGuest ) {

            return $this->redirect(['cp/index']);

        }
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ( ( $email = Yii::$app->request->get('email') ) ) {

            $model->email = $email;

        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->redirect(['cp/index']);

        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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

    public function actionInvite( $hash )
    {
        /** @var  $model User  */
        if( ($model      = User::find()
                ->where('invite_hash=:hash',
                    [
                        ':hash' => $hash
                    ])->one())) {

            $model->is_active = 1;
            $model->invite_hash=null;
            $model->save();
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "You user"));
            return $this->redirect(['/site/login', 'email'=>$model->email]);

        }
        Yii::$app->getSession()->setFlash('error', Yii::t("app", "sorry"));
        return $this->redirect(['/']);


    }
}
