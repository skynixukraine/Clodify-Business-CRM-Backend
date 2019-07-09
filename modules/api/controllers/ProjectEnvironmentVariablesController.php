<?php

namespace app\modules\api\controllers;

use app\models\ProjectEnvironmentVariable;
use app\modules\api\components\Api\Processor;
use viewModel\ProjectEnvironmentVariableCreate;
use viewModel\ViewModelInterface;
use yii\db\ActiveRecordInterface;
use app\modules\api\components\Api\Access;

class ProjectEnvironmentVariablesController extends DefaultController
{
    public function actionCreate(): void
    {
        $this->di
            ->set(ActiveRecordInterface::class, ProjectEnvironmentVariable::class)
            ->set(ViewModelInterface::class, ProjectEnvironmentVariableCreate::class)
            ->set(Access::class, [
                'methods' => [Processor::METHOD_POST],
                'checkAccess' => true,
            ])
            ->get('Processor')
            ->respond();
    }
}