<?php
/**
 * Create By Skynix Team
 * Author: maryna zhezhel
 * Date: 17/1/19
 * Time: 3:19 PM
 */

namespace app\modules\api\controllers;
use app\modules\api\components\Api\Processor;


class VacationHistoryItemsController extends DefaultController
{
    public function actionIndex()
    {
        $this->di
        ->set('yii\db\ActiveRecordInterface', 'app\models\VacationHistoryItem')
        ->set('viewModel\ViewModelInterface', 'viewModel\VacationHistoryItemsFetch')
        ->set('app\modules\api\components\Api\Access', [
            'methods' => [Processor::METHOD_GET],
            'checkAccess' => true
        ])
        ->get('Processor')
        ->respond();
    }
}