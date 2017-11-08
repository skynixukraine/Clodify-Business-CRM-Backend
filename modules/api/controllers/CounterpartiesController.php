<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 07.11.17
 * Time: 9:11
 */
namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class CounterpartiesController extends DefaultController
{
    public function actionCreate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Counterparty')
            ->set('viewModel\ViewModelInterface', 'viewModel\CounterpartyCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_POST],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionUpdate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Counterparty')
            ->set('viewModel\ViewModelInterface', 'viewModel\CounterpartyUpdate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDelete()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Counterparty')
            ->set('viewModel\ViewModelInterface', 'viewModel\CounterpartyDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_DELETE ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Counterparty')
            ->set('viewModel\ViewModelInterface', 'viewModel\CounterpartyFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

}