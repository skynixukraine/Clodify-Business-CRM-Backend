<?php

declare(strict_types=1);

namespace app\commands;

use app\models\MonitoringService;
use app\models\MonitoringServiceQueue;
use GuzzleHttp\Client;
use Yii;
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

    public function actionMonitoring()
    {
        $serviceQueues = MonitoringServiceQueue::find()
            ->where(['status' => MonitoringServiceQueue::STATUS_NEW])
            ->limit(10)
            ->orderBy('id ASC')
            ->all();

        $client = new Client();

        foreach ($serviceQueues as $serviceQueue) {
            $service = $serviceQueue->service;

            $serviceQueue->status = MonitoringServiceQueue::STATUS_IN_PROGRESS;

            try {
                $response = $client->get($service->url);
            } catch (\Exception $e) {
                $serviceQueue->status = MonitoringServiceQueue::STATUS_FAILED;
                $serviceQueue->results = 'Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString();
                $serviceQueue->save();
                continue;
            }

            $email = Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo(array_map('trim', explode(',', $service->notification_emails)));

            if ($response->getStatusCode() === 200) {
                if ($service->status === MonitoringService::STATUS_FAILED) {
                    $service->status = MonitoringService::STATUS_READY;

                    $email->setSubject('Site ' . $service->url . ' is ready now')
                        ->setHtmlBody('Site <a href="' . $service->url . '">' . $service->url . '</a> is ready now')
                        ->send();
                }
            } else {
                if ($service->status === MonitoringService::STATUS_FAILED) {
                    if (time() - strtotime($service->notification_sent_date) > 10800) {
                        $isSent = $email->setSubject('Site ' . $service->url . ' is still failed')
                            ->setHtmlBody('Site <a href="' . $service->url . '">' . $service->url . '</a> is still failed')
                            ->send();

                        if ($isSent) {
                            $service->notification_sent_date = date('Y-m-d H:i:s');
                        }
                    }
                } else {
                    $isSent = $email->setSubject('Site ' . $service->url . ' is failed')
                        ->setHtmlBody('Site <a href="' . $service->url . '">' . $service->url . '</a> is failed')
                        ->send();

                    if ($isSent) {
                        $service->notification_sent_date = date('Y-m-d H:i:s');
                    }
                    $service->status = MonitoringService::STATUS_FAILED;
                }
            }

            $serviceQueue->status = MonitoringServiceQueue::STATUS_COMPLETED;
            $serviceQueue->results = $response->getBody()->getContents();

            $serviceQueue->save();
            $service->save();
        }
    }
}