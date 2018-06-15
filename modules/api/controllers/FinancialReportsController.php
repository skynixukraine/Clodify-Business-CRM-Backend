<?php
/**
 * Created by Skynix Team
 * Date: 21.07.17
 * Time: 12:25
 */

namespace app\modules\api\controllers;


use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\modules\api\components\Api\Processor;

class FinancialReportsController extends DefaultController
{

    public function actionView()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportView')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET ],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

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


    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportFetch')
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
            ->set('app\models\FinancialReport', ['scenario' => FinancialReport::SCENARIO_FINANCIAL_REPORT_UPDATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportUpdate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionLock()
    {
        $this->di
            ->set('app\models\FinancialReport', ['scenario' => FinancialReport::SCENARIO_FINANCIAL_REPORT_UPDATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportLock')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionYearly()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialYearlyReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportYearly')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionUnlock()
    {
        $this->di
            ->set('app\models\FinancialReport', ['scenario' => FinancialReport::SCENARIO_FINANCIAL_REPORT_UPDATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialReportUnlock')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionIncomeAdd()
    {
        $this->di
            ->set('app\models\FinancialIncome', ['scenario' => FinancialIncome::SCENARIO_FINANCIAL_INCOME_CREATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialIncome')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialIncomeCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionIncomeFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialIncome')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialIncomeFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionIncomeDelete()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\FinancialIncome')
            ->set('viewModel\ViewModelInterface', 'viewModel\FinancialIncomeDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_DELETE ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

}