<?php
/**
 * Created by Skynix Team
 * Date: 26.02.17
 * Time: 14:15
 */

namespace app\modules\api\controllers;

use app\models\User;
use app\modules\api\components\Api\Processor;

class PasswordController extends DefaultController
{
    public function actionReset()
    {
        $this->di
            ->set('app\models\User', ['scenario' => User::SCENARIO_CHANGE_PASSWORD])
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\ResetPassword')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionChange()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\ChangePassword')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }
}