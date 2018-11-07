<?php

namespace app\modules\coreApi\controllers;

use app\models\CoreClient;
use app\modules\coreApi\components\Api\Processor;

class ClientsController extends DefaultController
{
    public function actionIndex()
    {

        $this->di
            ->set('app\models\CoreClient', ['scenario' => CoreClient::SCENARIO_PRE_REGISTER_VALIDATION])
            ->set('yii\db\ActiveRecordInterface', 'app\models\CoreClient')
            ->set('viewModel\ViewModelInterface', 'viewModel\ClientRegistration')
            ->set('app\modules\coreApi\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }
}
