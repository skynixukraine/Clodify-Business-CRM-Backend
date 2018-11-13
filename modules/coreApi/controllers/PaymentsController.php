<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/13/18
 * Time: 9:59 AM
 */

namespace app\modules\coreApi\controllers;
use app\modules\coreApi\components\Api\Processor;

class PaymentsController extends DefaultController
{
    public function actionCallback()
    {

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\CoreClient')
            ->set('viewModel\ViewModelInterface', 'viewModel\PaymentCallback')
            ->set('app\modules\coreApi\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }


    public function actionStatus()
    {

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\CoreClient')
            ->set('viewModel\ViewModelInterface', 'viewModel\PaymentStatus')
            ->set('app\modules\coreApi\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }
}