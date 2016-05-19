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
use yii\web\UploadedFile;


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
                        'actions'   => ['index', 'suspend', 'activate', 'upload', 'uploaded', 'photo', 'sing'],
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
                    'upload'    => ['get', 'post'],
                    'uploaded'  => ['get', 'post'],
                    'photo'     => ['get', 'post'],
                    'sing'      => ['get', 'post'],
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
    public function actionUpload()
    {

        $fileName = 'file';
        $uploadPath = __DIR__ . '/../../../data/' . Yii::$app->user->id . '/photo/';
        if (!is_dir($uploadPath))
        {
            mkdir($uploadPath, 0777, true);
        }

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            //Print file data
            //print_r($file);

            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                //Now save file data to database

                echo \yii\helpers\Json::encode($file);
            }else{
                return $this->render('index');
            }
        }

        return false;

        }
    public function actionUploaded()
    {
        $pathuser = __DIR__ . '/../../../data/' . Yii::$app->user->id;
        if ( file_exists( $pathuser) &&  file_exists( $pathuser . '/sing/')) {


        }else{
            $fileName = 'file';
            $path = __DIR__ . '/../../../data/' . Yii::$app->user->id . '/sing/';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            if (isset($_FILES[$fileName])) {
                $file = \yii\web\UploadedFile::getInstanceByName($fileName);

                //Print file data
                //print_r($file);

                if ($file->saveAs($path . '/' . $file->name)) {
                    //Now save file data to database

                    echo \yii\helpers\Json::encode($file);
                } else {
                    return $this->render('index');
                }
            }
        }
    }

    public function actionPhoto()
    {
        $result = [];
        try {
            $request = Yii::$app->getRequest()->post();
            User::setUserPhoto($request['photo']);
            $result['success'] = true;
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return json_encode($result);

    }
    public function actionSing()
    {
        $result = [];
        try {
            $request = Yii::$app->getRequest()->post();
            User::setUserSing($request['sing']);
            $result['success'] = true;
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return json_encode($result);

    }


}