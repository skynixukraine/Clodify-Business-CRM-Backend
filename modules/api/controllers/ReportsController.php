<?php

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class ReportsController extends DefaultController
{

    public function actionIndex(){

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Report')
            ->set('viewModel\ViewModelInterface', 'viewModel\ReportsFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }
}   
