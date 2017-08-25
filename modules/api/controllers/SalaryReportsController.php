<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 22.08.17
 * Time: 15:28
 */

namespace app\modules\api\controllers;


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
}