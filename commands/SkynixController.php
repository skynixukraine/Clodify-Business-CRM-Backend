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
            ->where('ms.is_enabled=1 AND (msq.status IN(\'new\', \'in progress\') OR `msq`.id IS NULL)')
            ->groupBy('ms.id')
            ->having('count(msq.id) = 0')
            ->all();

        foreach ($services as $service) {
            $serviceQueue = new MonitoringServiceQueue();
            $serviceQueue->service_id = $service['id'];
            $serviceQueue->status = 'new';
            $serviceQueue->save();
        }
    }
}