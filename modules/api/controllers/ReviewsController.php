<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 8/5/18
 * Time: 7:51 PM
 */

namespace app\modules\api\controllers;
use app\modules\api\components\Api\Processor;


class ReviewsController extends DefaultController
{
    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\ReviewsFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}