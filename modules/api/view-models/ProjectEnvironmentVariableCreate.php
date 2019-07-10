<?php

namespace viewModel;

use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\ProjectEnvironment;
use app\models\ProjectEnvironmentVariable;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class ProjectEnvironmentVariableCreate extends ViewModelAbstract
{
    /**
     * @var ProjectEnvironment|null
     */
    private $environment;

    public function __construct()
    {
        $id = Yii::$app->request->getQueryParam('id', 0);
        $envName = Yii::$app->request->getQueryParam('branch_name');

        $this->environment = ProjectEnvironment::findOne([
            'branch' => $envName,
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

        if (! isset($this->postData['key'], $this->postData['value'])) {
            return $this->addError(Processor::ERROR_PARAM, 'Key and value are required');
        }

        $key = $this->postData['key'];
        $value = $this->postData['value'];

        $variableExists = ProjectEnvironmentVariable::find()->where([
            'name' => $key,
            'project_environment_id' => $this->environment->id,
        ])->exists();

        if ($variableExists) {
            return $this->addError(Processor::ERROR_PARAM, 'Variable with key ' . $key . ' already exists');
        }

        $variable = new ProjectEnvironmentVariable();
        $variable->name = $key;
        $variable->value = $value;
        $variable->project_environment_id = $this->environment->id;
        $variable->save();

        $this->environment->last_updated = date('Y-m-d H:i:s');
        $this->environment->save();
    }

    private function checkPermission(): bool
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {
            return true;
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