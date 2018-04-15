<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 4/14/18
 * Time: 10:56 AM
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;


class EmergencyController extends DefaultController
{
    public function actionRegister()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Emergency')
            ->set('viewModel\ViewModelInterface', 'viewModel\EmergencyRegister')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_POST],
                'checkAccess' => false
            ])
            ->get('Processor')
            ->respond();
    }
}