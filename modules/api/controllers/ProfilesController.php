<?php
/**
 * Created by Skynix Team
 * Date: 18.04.17
 * Time: 10:42
 */

namespace app\modules\api\controllers;

use app\models\Profile;
use app\modules\api\components\Api\Processor;

class ProfilesController extends DefaultController
{
    public function actionFetch()
    {
        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\ProfileFetch')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_GET ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();
    }
}