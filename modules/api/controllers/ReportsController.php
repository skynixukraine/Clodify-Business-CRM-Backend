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
    
    public function actionDatePeriod(){
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Report')
            ->set('viewModel\ViewModelInterface', 'viewModel\DatePeriod')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDelete(){
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Report')
            ->set('viewModel\ViewModelInterface', 'viewModel\ReportDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_DELETE ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionEdit() {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Report')
            ->set('viewModel\ViewModelInterface', 'viewModel\ReportsEdit')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionCreateEdit()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Report')
            ->set('viewModel\ViewModelInterface', 'viewModel\CreateEditReport')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST, Processor::METHOD_PUT],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionApprove(){

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Report')
            ->set('viewModel\ViewModelInterface', 'viewModel\ReportApprove')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionDisapprove(){

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Report')
            ->set('viewModel\ViewModelInterface', 'viewModel\ReportDisApprove')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }

}   
