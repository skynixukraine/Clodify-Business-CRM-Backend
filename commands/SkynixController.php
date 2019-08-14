<?php

declare(strict_types=1);

namespace app\commands;

use app\models\MonitoringServiceQueue;
use yii\db\Query;

class SkynixController extends DefaultController
{
    public function actionMonitoringServiceQueue()
    {
        $services = (new Query())
            ->select('ms.id')
            ->from('monitoring_services as ms')
            ->leftJoin('monitoring_service_queue as msq', 'ms.id = msq.service_id')
            ->where('ms.is_enabled=1')
            ->groupBy('ms.id')
            ->having('sum(IF(msq.status = \'failed\' OR msq.status IS NULL, 0, 1)) = 0')
            ->all();

        foreach ($services as $service) {
            $serviceQueue = new MonitoringServiceQueue();
            $serviceQueue->service_id = $service['id'];
            $serviceQueue->status = 'new';
            $serviceQueue->save();
        }
    }
}