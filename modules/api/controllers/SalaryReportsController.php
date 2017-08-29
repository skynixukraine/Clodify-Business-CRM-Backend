<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 22.08.17
 * Time: 15:28
 */

namespace app\modules\api\controllers;

use app\models\SalaryReportList;
use app\models\SalaryReport;
use app\modules\api\components\Api\Processor;

class SalaryReportsController extends DefaultController
{

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\SalaryReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\SalaryReportFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionCreate()
    {
        $this->di
            ->set('app\models\SalaryReport', ['scenario' => SalaryReport::SCENARIO_SALARY_REPORT_CREATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\SalaryReport')
            ->set('viewModel\ViewModelInterface', 'viewModel\SalaryReportCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionListsUpdate()
    {
        $this->di
            ->set('app\models\SalariReportList', ['scenario' => SalaryReportList::SCENARIO_SALARY_REPORT_LISTS_UPDATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\SalaryReportList')
            ->set('viewModel\ViewModelInterface', 'viewModel\SalaryListUpdate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}