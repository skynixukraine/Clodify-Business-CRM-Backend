<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 13:25
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class InvoicesController extends DefaultController
{
    public function actionCreate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Invoice')
            ->set('viewModel\ViewModelInterface', 'viewModel\InvoiceCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

}