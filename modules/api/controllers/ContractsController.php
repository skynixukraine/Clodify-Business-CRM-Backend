<?php
/**
 * Created by Skynix Team
 * Date: 20.04.17
 * Time: 11:18
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class ContractsController extends DefaultController
{
    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Contract')
            ->set('viewModel\ViewModelInterface', 'viewModel\ContractsFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

}