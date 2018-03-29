<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 29.03.18
 * Time: 11:53
 */

namespace app\modules\api\controllers;

use app\models\FixedAsset;
use app\modules\api\components\Api\Processor;

class FixedAssetsController extends DefaultController
{

    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\FixedAsset')
            ->set('viewModel\ViewModelInterface', 'viewModel\FixedAssetFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

}