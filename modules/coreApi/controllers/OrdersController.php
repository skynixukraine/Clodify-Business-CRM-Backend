<?php

namespace app\modules\coreApi\controllers;

use app\models\CoreOrder;
use app\modules\coreApi\components\Api\Processor;

class OrdersController extends DefaultController
{
    public function actionCreate()
    {

        $this->di
            ->set('app\models\CoreOrder', ['scenario' => CoreOrder::SCENARIO_CREATE_VALIDATION])
            ->set('yii\db\ActiveRecordInterface', 'app\models\CoreOrder')
            ->set('viewModel\ViewModelInterface', 'viewModel\OrderCreate')
            ->set('app\modules\coreApi\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }
}
