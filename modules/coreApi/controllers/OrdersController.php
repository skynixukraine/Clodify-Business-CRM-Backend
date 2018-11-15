<?php

namespace app\modules\coreApi\controllers;

use app\models\CoreOrder;
use app\modules\coreApi\components\Api\Processor;

class OrdersController extends DefaultController
{
    public function actionFetch()
    {

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\CoreOrder')
            ->set('viewModel\ViewModelInterface', 'viewModel\OrderFetch')
            ->set('app\modules\coreApi\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }
}
