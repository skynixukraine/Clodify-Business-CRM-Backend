<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 19.10.17
 * Time: 10:18
 */
namespace app\modules\api\controllers;

use app\models\Setting;
use app\modules\api\components\Api\Processor;

class SettingsController extends DefaultController
{
    public function actionUpdate()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\Setting')
            ->set('viewModel\ViewModelInterface', 'viewModel\SettingUpdate')
            ->set('app\modules\api\components\Api\Access', [
                'methods' => [Processor::METHOD_PUT],
                'checkAccess' => true
            ])
            ->get('Processor')
            ->respond();
    }
}