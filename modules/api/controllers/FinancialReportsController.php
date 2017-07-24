<?php
/**
 * Created by Skynix Team
 * Date: 21.07.17
 * Time: 12:25
 */

namespace app\modules\api\controllers;


use app\models\FinancialReport;
use app\modules\api\components\Api\Processor;

class FinancialReportsController extends DefaultController
{

    public function actionCreate()
    {
        $this->di
            ->set('app\models\FinancialReport', ['scenario' => FinancialReport::SCENARIO_FINANCIAL_REPORT_CREATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionUpdate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportUpdate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

}