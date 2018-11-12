<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use app\modules\api\models\ApiAccessToken;
use Yii;
use app\models\ApiLoginForm;
use app\modules\api\components\Api\Processor;


class Auth extends ViewModelAbstract
{

    /** @var  \app\models\User */
    public $model;
    public $token;

    public function define()
    {

        if ($this->validate()) {
            $loginForm = new ApiLoginForm();
            $loginForm->email       = $this->model->email;
            $this->model            = $loginForm;

            if ( $this->validate() ) {

                /** @var $token CoreClientKey */
                if ( ( $clientKey = $this->model->login() ) ) {

                    $this->setData([
                        'access_key'  => $clientKey->access_key,
                        'user_id'       => $clientKey->client_id,
                    ]);

                }

            }

        }
    }

}
