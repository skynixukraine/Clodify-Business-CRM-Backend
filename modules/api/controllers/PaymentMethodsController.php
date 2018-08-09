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

}