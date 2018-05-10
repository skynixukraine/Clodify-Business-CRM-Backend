<?php
/**
 * Created by Skynix Team
 * Date: 21.07.17
 * Time: 12:25
 */

namespace app\modules\api\controllers;


use app\models\DelayedSalary;
use app\modules\api\components\Api\Processor;

class DelayedSalaryController extends DefaultController
{

    public function actionCreate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\DelayedSalary')
            ->set('viewModel\ViewModelInterface', 'viewModel\DelayedSalaryCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

}