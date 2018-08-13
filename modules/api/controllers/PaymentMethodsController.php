<?php
/**
 * Created by Skynix Team
 * Date: 26.02.17
 * Time: 14:15
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class PaymentMethodsController extends DefaultController
{
    public function actionCreate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\PaymentMethod')
            ->set('viewModel\ViewModelInterface', 'viewModel\PaymentMethodCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\PaymentMethod')
            ->set('viewModel\ViewModelInterface', 'viewModel\PaymentMethodFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionUpdate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\PaymentMethod')
            ->set('viewModel\ViewModelInterface', 'viewModel\PaymentMethodUpdate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDelete()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\PaymentMethod')
            ->set('viewModel\ViewModelInterface', 'viewModel\PaymentMethodDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_DELETE ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

}