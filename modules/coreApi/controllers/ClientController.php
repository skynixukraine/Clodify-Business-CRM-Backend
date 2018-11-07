<?php

namespace app\modules\coreApi\controllers;

use app\modules\coreApi\components\Api\Processor;

class ClientController extends DefaultController
{
    public function actionCredentials()
    {

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\CoreClient')
            ->set('viewModel\ViewModelInterface', 'viewModel\ClientCredentials')
            ->set('app\modules\coreApi\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }
}
