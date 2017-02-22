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

    /** @var  \app\models\User */
    public $model;

    public function define()
    {
        $this->model->scenario = 'api-login';

        $loginForm = new ApiLoginForm();
        $loginForm->email       = $this->model->email;
        $loginForm->password    = $this->model->password;
        $this->model            = $loginForm;

        if( $this->validate() &&
            ($token =  $this->model->login() ) ) {

            $this->setData([
                'access_token' => $token->access_token,
                'user_id' => $token->user_id
            ]);

        }


    }
}
