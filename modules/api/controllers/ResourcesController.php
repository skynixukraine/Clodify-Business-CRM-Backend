<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 05.04.14
 * Time: 16:25
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class ResourcesController extends DefaultController
{
    /**
     * https://jira.skynix.co/browse/SCA-125
     */
    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\ResourceFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_GET],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    /**
     * https://jira.skynix.co/browse/SCA-126
     */
    public function actionIavailable()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\ResourceIavailable')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }

    /**
     * https://jira.skynix.co/browse/SCA-127
     */
    public function actionStart()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\ResourceStart')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_POST],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}