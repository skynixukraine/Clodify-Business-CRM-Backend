<?php
/**
 * Created by Skynix Team
 * Date: 15.03.17
 * Time: 10:52
 */

namespace app\modules\api\controllers;

use app\models\Milestone;
use app\models\Project;
use app\modules\api\components\Api\Processor;

class ProjectsController extends DefaultController
{
    public function actionCreate()
    {
        $this->di
            ->set('app\models\Project', ['scenario' => 'api-create'])
            ->set('yii\db\ActiveRecordInterface', 'app\models\Project')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProjectCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Project')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProjectFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionSuspend()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Project')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProjectSuspend')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionEdit()
    {
        $this->di
            ->set('app\models\Project', ['scenario' => Project::SCENARIO_UPDATE_ADMIN])
            ->set('yii\db\ActiveRecordInterface', 'app\models\Project')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProjectEdit')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDelete()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Project')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProjectDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_DELETE ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionActivate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Project')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProjectActivate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionCreateMilestone()
    {
        $this->di
            ->set('app\models\Milestone', ['scenario' => Milestone::SCENARIO_CREATE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\Milestone')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProjectMilestoneCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }

    public function actionCloseMilestone()
    {
        $this->di
            ->set('app\models\Milestone', ['scenario' => Milestone::SCENARIO_CLOSE])
            ->set('yii\db\ActiveRecordInterface', 'app\models\Milestone')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProjectMilestoneClose')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_PUT ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();

    }

}