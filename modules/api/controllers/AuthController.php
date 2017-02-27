<?php
/**
 * Created by Skynix Team
 * Date: 9/5/16
 * Time: 21:15
 */

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;

class AuthController extends DefaultController
{

    public function actionIndex(){

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\Auth')
            ->set('app\modules\api\components\Api\Access', [
                'methods'       => [ Processor::METHOD_POST ],
                'checkAccess'   => false
            ])
            ->get('Processor')
            ->respond();

    }
}
