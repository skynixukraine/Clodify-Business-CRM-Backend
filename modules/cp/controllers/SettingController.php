<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 22.02.16
 * Time: 16:24
 */
namespace app\modules\cp\controllers;

use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\web\User;
use app\models\Project;


class SettingController extends DefaultController
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
                        'actions'   => ['index', 'suspend', 'activate'],
                        'allow'     => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get', 'post'],
                    'suspend'   => ['get', 'post'],
                    'activate'  => ['get', 'post'],

                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSuspend()
    {
        if (( $id = Yii::$app->request->get("id") ) ) {
            $model =  ProjectDeveloper::find()
                ->where('project_id=:Id',[
                    ':Id' => $id,
                ])
                ->one();

            $model->status = ProjectDeveloper::STATUS_INACTIVE;
            $model->save(true, ['status']);
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "You suspended project " . $id));
            return $this->redirect(['setting/index']);
        }

    }
    public function actionActivate()
    {
        if (( $id = Yii::$app->request->get("id") ) ) {
            $model =  ProjectDeveloper::find()
                ->where('project_id=:Id',[
                    ':Id' => $id,
                ])
                ->one();
            $model->status = ProjectDeveloper::STATUS_ACTIVE;
            $model->save(true, ['status']);
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "You activsted project " . $id));
            return $this->redirect(['setting/index']);
        }

    }

}