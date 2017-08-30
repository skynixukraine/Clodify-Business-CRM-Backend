<?php
/**
 * Created by Skynix Team
 * Date: 06.03.17
 * Time: 15:34
 */

namespace app\modules\api\controllers;
use app\models\User;

use app\modules\api\components\Api\Processor;

class UsersController extends DefaultController
{

    public function actionIndex()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UsersFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }
    public function actionCreate(){
        $this->di
            ->set('app\models\User', ['scenario' => User::SCENARIO_CREATE_USER])
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UserCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionActivate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UserActivate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDeactivate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UserDeactivate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionView(){

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UserView')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDelete()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UserDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_DELETE ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionEdit()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UserEdit')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionSign()
    {
        $this->di
            ->set('app\models\User', ['scenario' => User::ATTACH_USERS_SIGN])
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UsersSign')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionPhoto()
    {
        $this->di
            ->set('app\models\User', ['scenario' => User::ATTACH_PHOTO_USERS])
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UserPhoto')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionWorkHistory()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UsersWorkHistory')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionViewPhoto()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\UserViewPhoto')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionAccessToken() {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\AccessToken')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

}