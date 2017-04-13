<?php
/**
 * Created by Skynix Team
 * Date: 11.04.17
 * Time: 12:33
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class SurveysController extends DefaultController
{
    public function actionDelete()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Survey')
            ->set('viewModel\ViewModelInterface', 'viewModel\SurveysDelete')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_DELETE ],
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Survey')
            ->set('viewModel\ViewModelInterface', 'viewModel\SurveysFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionCreate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Survey')
            ->set('viewModel\ViewModelInterface', 'viewModel\SurveysCreate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_POST],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    public function actionView()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Survey')
            ->set('viewModel\ViewModelInterface', 'viewModel\SurveysView')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

}