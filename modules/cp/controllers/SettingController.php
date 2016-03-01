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
//use yii\web\User;
use app\models\User;
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
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN],
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
        $model = User::find()
            ->where('id=:ID', [
                ':ID' => Yii::$app->user->id
            ])->one();

        if($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You edited yours data"));
                return $this->redirect(['index']);
            }
        }
        return $this->render("index", ['model' => $model]);
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
        }
        return $this->redirect(['setting/index']);
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
        }
        return $this->redirect(['setting/index']);
    }

}