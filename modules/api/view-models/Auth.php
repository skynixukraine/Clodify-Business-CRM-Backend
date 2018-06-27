<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use app\modules\api\models\ApiAccessToken;
use Yii;
use app\models\User;
use app\modules\api\models\ApiLoginForm;
use app\modules\api\components\Api\Processor;


class Auth extends ViewModelAbstract
{

    /** @var  \app\models\User */
    public $model;
    public $token;

    public function define()
    {
        $this->model->scenario = 'api-login';

        if ($this->validate()) {
            $loginForm = new ApiLoginForm();
            $loginForm->email       = $this->model->email;
            $loginForm->password    = $this->model->password;
            $this->model            = $loginForm;

            if ( $this->validate() ) {

                /** @var $token ApiAccessToken */
                if ( ( $token = $this->model->login() ) ) {

                    $this->setData([
                        'access_token'  => $token->access_token,
                        'user_id'       => $token->user_id,
                        'role'          => User::findOne( $token->user_id )->role,
                        'crowd_token'   => $token->crowd_token
                    ]);

                }

            }

        }
    }

}
