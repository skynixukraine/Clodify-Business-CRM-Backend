<?php

declare(strict_types=1);

namespace viewModel;

use app\models\MonitoringServiceQueue;
use app\models\Project;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class MonitoringServiceFetch extends ViewModelAbstract
{
    /**
     * @var Project|null
     */
    private $project;

    public function __construct()
    {
        $id = Yii::$app->request->getQueryParam('id', 0);

        $this->project = Project::findOne(['id' => $id]);
    }

    /**
     * {@inheritDoc}
     */
    public function define()
    {
        if (! User::hasPermission([User::ROLE_ADMIN])) {
            return $this->addError(Processor::STATUS_CODE_UNAUTHORIZED, 'Access is forbidden');
        }

        if (! $this->project) {
            return $this->addError(Processor::ERROR_PARAM, 'Project not found');
        }

        $services = $this->project->monitoringServices;

        foreach ($services as $service) {
            $serviceResult = [
                'id' => $service->id,
                'status' => $service->status,
                'url' => $service->url,
                'is_enabled' => $service->is_enabled,
                'notification_emails' => $service->notification_emails,
                'project_id' => $service->project_id,
            ];

            $queue = $service->getMonitoringServiceQueues()
                ->where(['status' => MonitoringServiceQueue::STATUS_NEW])
                ->orderBy('id DESC')
                ->all();

            foreach ($queue as $serviceQueue) {
                $serviceQueueResult['id'] = $serviceQueue->id;
                $serviceQueueResult['status'] = $serviceQueue->status;
                $serviceQueueResult['results'] = $serviceQueue->results;
                $serviceQueueResult['service_id'] = $serviceQueue->service_id;

                $serviceResult['queue'][] = $serviceQueueResult;
            }

            $this->data[] = $serviceResult;
        }
    }
}