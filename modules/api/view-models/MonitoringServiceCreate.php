<?php

declare(strict_types=1);

namespace viewModel;

use app\models\MonitoringService;
use app\models\Project;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class MonitoringServiceCreate extends ViewModelAbstract
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

        if (! isset($this->postData['url'], $this->postData['notification_emails'])) {
            return $this->addError(Processor::ERROR_PARAM, 'Url and notification emails are required');
        }

        $monitoringService = new MonitoringService();
        $monitoringService->url = $this->postData['url'];
        $monitoringService->notification_emails = $this->postData['notification_emails'];
        $monitoringService->project_id = $this->project->id;

        if (! $monitoringService->save()) {
            return $this->addError(Processor::ERROR_PARAM, 'Monitoring service can not be save.');
        }
    }
}