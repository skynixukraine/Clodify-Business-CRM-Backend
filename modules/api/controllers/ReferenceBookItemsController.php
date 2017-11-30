<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 09.11.17
 * Time: 8:52
 */

namespace app\modules\api\controllers;


use app\modules\api\components\Api\Processor;

class ReferenceBookItemsController extends DefaultController
{

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\ReferenceBook')
            ->set('viewModel\ViewModelInterface', 'viewModel\ReferenceBookFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}