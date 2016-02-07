<?php
/**
 * Created by WebAIS.
 * User: Wolf
 * Date: 02.10.2015
 * Time: 10:38
 */

namespace app\modules\cp\controllers;
use app\models\Report;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;

class IndexController extends DefaultController
{
    public $enableCsrfValidation = false;
    public $layout = "admin";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => [ 'index', 'test' ],
                        'allow' => true,
                        'roles' => [User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'      => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionTest()
    {
        Yii::$app->mailer->compose('test',
            ['username' => "Oleksii"])
            ->setTo( "olha@webais.company" )
            ->setFrom( Yii::$app->params['adminEmail'])
            ->setSubject( "This is a subject of the test email" )
            ->send();
        Yii::$app->end();
    }

    public function actionIndex()
    {
        $model = new Report();
        if ( $model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->id;
            if( $model->validate()) {

                Yii::$app->user->getIdentity()->last_name;
                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You report has been added"));
                return $this->refresh();
            }
        }
        return $this->render('index',['model' => $model]);
    }
}