<?php

declare(strict_types=1);

namespace app\modules\api\controllers;

use app\models\MonitoringService;
use app\modules\api\components\Api\Access;
use app\modules\api\components\Api\Processor;
use viewModel\MonitoringServiceCreate;
use viewModel\MonitoringServiceUpdate;
use viewModel\MonitoringServiceFetch;
use viewModel\MonitoringServiceDelete;
use viewModel\ViewModelInterface;
use yii\db\ActiveRecordInterface;

class MonitoringServiceController extends DefaultController
{
    public function actionCreate()
    {
        $this->di
            ->set(ActiveRecordInterface::class, MonitoringService::class)
            ->set(ViewModelInterface::class, MonitoringServiceCreate::class)
            ->set(Access::class, [
                'methods' => [Processor::METHOD_POST],
                'checkAccess' => true,
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionFetch()
    {
        $this->di
            ->set(ActiveRecordInterface::class, MonitoringService::class)
            ->set(ViewModelInterface::class, MonitoringServiceFetch::class)
            ->set(Access::class, [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true,
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionUpdate()
    {
        $this->di
            ->set(ActiveRecordInterface::class, MonitoringService::class)
            ->set(ViewModelInterface::class, MonitoringServiceUpdate::class)
            ->set(Access::class, [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true,
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDelete()
    {
        $this->di
            ->set(ActiveRecordInterface::class, MonitoringService::class)
            ->set(ViewModelInterface::class, MonitoringServiceDelete::class)
            ->set(Access::class, [
                'methods' => [Processor::METHOD_DELETE],
                'checkAccess' => true,
            ])
            ->get('Processor')
            ->respond();
    }
}