<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 08.11.17
 * Time: 13:19
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class OperationTypesController extends DefaultController
{

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\OperationType')
            ->set('viewModel\ViewModelInterface', 'viewModel\OperationTypeFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}