<?php
/**
 * Created by Skynix Team
 * Date: 9/5/16
 * Time: 21:15
 */

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\components\ApiProcessor\ApiProcessor;
use app\models\Contact;

class AuthController extends DefaultController
{
    /*public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['index'];
        return $behaviors;
    }*/


    public function actionIndex(){

        $this->di
            ->set('yii\db\ActiveRecordInterface', 'app\models\User')
            ->set('viewModel\ViewModelInterface', 'viewModel\Auth')
            ->set('app\modules\api\components\ApiProcessor\ApiProcessorAccess', [
                'methods'       => [ ApiProcessor::METHOD_POST ],
                'checkAccess'   => true
            ])
            ->get('ApiProcessor')
            ->respond();

    }
}
