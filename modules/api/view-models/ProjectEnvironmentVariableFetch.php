<?php

namespace viewModel;

use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\ProjectEnvironment;
use app\models\ProjectEnvironmentVariable;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class ProjectEnvironmentVariableFetch extends ViewModelAbstract
{
    /**
     * @var ProjectEnvironment|null
     */
    private $environment;

    public function __construct()
    {
        $id = Yii::$app->request->getQueryParam('id', 0);
        $envId = Yii::$app->request->getQueryParam('branch_name');

        $this->environment = ProjectEnvironment::findOne([
            'branch' => $envId,
            'project_id' => $id,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function define()
    {
        if (! $this->environment) {
            return $this->addError(Processor::ERROR_PARAM, 'Environment not found');
        }

        if (! $this->checkPermission()) {
            return $this->addError(Processor::STATUS_CODE_UNAUTHORIZED, 'Access is forbidden');
        }

        $query = ProjectEnvironmentVariable::find()->where([
            'project_environment_id' => $this->environment->id,
        ]);

        $key = Yii::$app->request->getQueryParam('key');

        if ($key) {
            $query->where['name'] = $key;
        }

        $this->data = array_map(function (ProjectEnvironmentVariable $variable) {
            $attributes = $variable->getAttributes();
            $attributes['value'] = Yii::$app->encrypter->decrypt($attributes['value']);
            return $attributes;
        }, $query->all());
    }

    private function checkPermission(): bool
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {
            return true;
        }

        if (Yii::$app->user->isGuest) {
            $apiKey = Yii::$app->request->getQueryParam('api_key');
            return $apiKey && $apiKey === $this->environment->project->api_key;
        }

        $envRoles = array_map('trim', explode(',', $this->environment->access_roles));
        if (! User::hasPermission($envRoles)) {
            return false;
        }

        if (User::hasPermission([User::ROLE_CLIENT])) {
            return ProjectCustomer::find()->where([
                'user_id' => Yii::$app->user->id,
                'project_id' => $this->environment->project_id,
            ])->exists();
        }

        return ProjectDeveloper::find()->where([
            'user_id' => Yii::$app->user->id,
            'project_id' => $this->environment->project_id,
        ])->exists();
    }
}