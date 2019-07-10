<?php

namespace viewModel;

use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\ProjectEnvironment;
use app\models\ProjectEnvironmentVariable;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class ProjectEnvironmentVariableDelete extends ViewModelAbstract
{
    /**
     * @var ProjectEnvironment|null
     */
    private $environment;

    private $variable;

    public function __construct()
    {
        $id = Yii::$app->request->getQueryParam('id', 0);
        $envName = Yii::$app->request->getQueryParam('branch_name');
        $varId = Yii::$app->request->getQueryParam('var_id');

        $this->environment = ProjectEnvironment::findOne([
            'branch' => $envName,
            'project_id' => $id,
        ]);

        $this->variable = ProjectEnvironmentVariable::findOne(['id' => $varId]);
    }

    /**
     * {@inheritDoc}
     */
    public function define()
    {
        if (! $this->environment) {
            return $this->addError(Processor::ERROR_PARAM, 'Environment not found');
        }

        if (! $this->variable) {
            return $this->addError(Processor::ERROR_PARAM, 'Variable not found');
        }

        if (! $this->variable->projectEnvironment->equals($this->environment)) {
            return $this->addError(Processor::ERROR_PARAM, 'Variable not belong to this environment');
        }

        if (! $this->checkPermission()) {
            return $this->addError(Processor::STATUS_CODE_UNAUTHORIZED, 'Access is forbidden');
        }

        $this->variable->delete();

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