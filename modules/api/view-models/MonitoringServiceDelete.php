<?php

declare(strict_types=1);

namespace viewModel;

use app\models\MonitoringService;
use app\models\Project;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class MonitoringServiceDelete extends ViewModelAbstract
{
    /**
     * @var Project|null
     */
    private $project;

    /**
     * @var MonitoringService|null
     */
    private $service;

    public function __construct()
    {
        $projectId = Yii::$app->request->getQueryParam('id', 0);
        $serviceId = Yii::$app->request->getQueryParam('service_id', 0);

        $this->project = Project::findOne(['id' => $projectId]);

        if ($this->project) {
            $this->service = $this->project->getMonitoringServices()->where(['id' => $serviceId])->one();
        }
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

        if (! $this->service) {
            return $this->addError(Processor::ERROR_PARAM, 'Monitoring service not found in the project');
        }

        if (! $this->service->delete()) {
            return $this->addError(Processor::ERROR_PARAM, 'Monitoring service can not be deleted.');
        }
    }
}