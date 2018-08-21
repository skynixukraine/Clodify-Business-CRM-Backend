<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 08.11.17
 * Time: 11:47
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class BusinessesController extends DefaultController
{
    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Business')
            ->set('viewModel\ViewModelInterface', 'viewModel\BusinessFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'        => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionCreate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Business')
            ->set('viewModel\ViewModelInterface', 'viewModel\BusinessCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionUpdate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Business')
            ->set('viewModel\ViewModelInterface', 'viewModel\BusinessUpdate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [ Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionDelete()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Business')
            ->set('viewModel\ViewModelInterface', 'viewModel\BusinessDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [ Processor::METHOD_DELETE],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }


}
