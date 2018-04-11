<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 04.04.14
 * Time: 14:05
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class BalancesController extends DefaultController
{

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Transaction')
            ->set('viewModel\ViewModelInterface', 'viewModel\BalanceFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}