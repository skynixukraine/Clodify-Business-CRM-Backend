<?php
/**
 * Created by Skynix Team
 * Date: 05.04.17
 * Time: 17:25
 */

namespace app\modules\api\controllers;

use app\models\User;
use app\modules\api\components\Api\Processor;

class CareersController extends DefaultController
{
    public function actionIndex()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Career')
            ->set('viewModel\ViewModelInterface', 'viewModel\CareersView')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();
    }
}