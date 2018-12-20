<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 12/17/18
 * Time: 5:27 PM
 */

namespace app\modules\api\controllers;
use app\modules\api\components\Api\Processor;


class MonthlyReviewsController extends DefaultController
{
    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\MonthlyReviewsFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}