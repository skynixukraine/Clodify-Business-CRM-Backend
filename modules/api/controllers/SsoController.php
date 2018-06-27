<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/27/18
 * Time: 10:10 AM
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;


class SsoController extends DefaultController
{

    public function actionGetConfig()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Setting')
            ->set('viewModel\ViewModelInterface', 'viewModel\SSOFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionCheck()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Setting')
            ->set('viewModel\ViewModelInterface', 'viewModel\SSOCheck')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();
    }

}