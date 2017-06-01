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
use app\models\User;
use app\models\Project;
use app\models\Storage;
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
                        'actions'   => ['index', 'suspend', 'activate', 'upload', 'uploaded', 'photo', 'sing', 'download'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES],
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
        $model = User::findOne(Yii::$app->user->id);
        $model->scenario = 'settings';

        if ($model->load(Yii::$app->request->post())) {

            if ($editorUa = Yii::$app->request->post('editorUa')) {
                $editorEn = Yii::$app->request->post('editorEn');
                $model->bank_account_en = $editorEn;
                $model->bank_account_ua = $editorUa;
            }

            // Projects tab functionality
            $this->assignToProject();

            if ($model->validate()) {

                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You. You have successfully saved your profile data"));
                return $this->redirect(['index']);
            }
        }
        $s = new Storage();
        $userPhoto = $s->getListFileUser('data/' . Yii::$app->user->id . '/photo/');
        $userSign = $s->getListFileUser('data/' . Yii::$app->user->id . '/sign/');
        $defaultPhoto = User::getUserPhoto();
        $defaultSing = User::getUserSing();
        return $this->render("index", ['model' => $model,
                            'defaultPhoto' => $defaultPhoto,
                            'defaultSing' => $defaultSing,
                            'bank_account_en' => $model->bank_account_en,
                            'bank_account_ua' => $model->bank_account_ua,
                            'userPhoto' => $userPhoto['Contents'],
                            'userSign' => $userSign['Contents'],
        ]);
    }

    public function actionDownload()
    {
        $userPhoto = Yii::$app->request->getQueryParam('photo');
        $s = new Storage();
        $result = $s->download($userPhoto);
        $arrayuserPhoto = explode('/',$userPhoto);
        $path_info = pathinfo(end($arrayuserPhoto));
        header('Content-Type: ' . $result['ContentType'] . '/' . $path_info['extension']);
        echo $result['Body'];
        exit();
    }

    public function actionUpload()
    {
        $fileName = 'file';

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            $s = new Storage();
            $pathFile = 'data/' . Yii::$app->user->id . '/photo/';
            $result = $s->upload($pathFile . $file->name, $file->tempName);

            if ($result['ObjectURL']) {
                //Now save file data to database

                echo \yii\helpers\Json::encode($file);
            }else{
                return $this->render('index');
            }
        }

        return false;

    }

    /**
     * @return string
     */
    public function actionUploaded()
    {
        $fileName = 'file';

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            $s = new Storage();
            $pathFile = 'data/' . Yii::$app->user->id . '/sign/';
            $result = $s->upload($pathFile . $file->name, $file->tempName);

            if ($result['ObjectURL']) {
                //Now save file data to database

                echo \yii\helpers\Json::encode($file);
            } else {
                return $this->render('index');
            }
        }

        return false;

    }

    /**
     * @return string
     */
    public function actionPhoto()
    {
        $result = [];
        try {
            $request = Yii::$app->getRequest()->post();
            User::setUserPhoto($request['photo']);
            $result['success'] = true;
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Thank You. You have successfully saved your avatar"));
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return json_encode($result);
    }

    /**
     * @return string
     */
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

    protected function assignToProject()
    {
        $assigns = Yii::$app->request->post('Project');
        $projects = Project::ProjectsCurrentUser(Yii::$app->user->id);
        /** @var Project $project */
        foreach ($projects as $project) {
            if (isset($assigns[$project->id])) {
                User::assignProject($project->id);
            } else {
                User::unassignProject($project->id);
            }
        }
    }

}