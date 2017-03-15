<?php
/**
 * Created by Skynix Team
 * Date: 15.03.17
 * Time: 10:52
 */
namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class ProjectsController extends DefaultController
{
    public function actionCreate(){

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

}