<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 21.07.17
 * Time: 17:40
 */
namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class FinancialReportsController extends DefaultController
{
    public function actionView()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportView')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}