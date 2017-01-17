<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use Yii;
use app\modules\api\models\ApiAccessToken;
use app\models\User;
use app\modules\api\models\ApiLoginForm;

class Auth extends ViewModelAbstract
{

    /** @var  \app\modules\api\models\ApiLoginForm */
    public $model;

    public function define()
    {
        $data = [];
        $this->model->scenario = 'api-login';

        $loginForm = new ApiLoginForm();
        $loginForm->email = $this->model->email;

        if( $this->validate() &&
            ($token =  $loginForm->login() ) ) {
            $data[
                'access_token'] = $token->access_token;

        }
        $this->setData($data);

    }
}
