<?php
/**
 * Created by Skynix Team
 * Date: 20.04.17
<<<<<<< HEAD
 * Time: 14:08
=======
 * Time: 11:18
>>>>>>> origin/develop
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class ContractsController extends DefaultController
{

    public function actionCreate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Contract')
            ->set('viewModel\ViewModelInterface', 'viewModel\ContractCreate')
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
            ->set('yii\db\ActiveRecordInterface', 'app\models\Contract')
            ->set('viewModel\ViewModelInterface', 'viewModel\ContractsFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionView()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Contract')
            ->set('viewModel\ViewModelInterface', 'viewModel\ContractView')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

}