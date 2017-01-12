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

    /** @var  \app\modules\api\models\Contact */
    public $model;

    public function define()
    {

        $loginForm = new ApiLoginForm();
        $loginForm->email= $this->postData['email'];
        $loginForm->password =$this->postData['password'];

        if($token = $loginForm->login() ) {

            $this->setData(
                [
                    'access_token' => $token->access_token
                ]
            );

        } else {
            if ( ( $errors = $loginForm->getErrors() ) ) {
                foreach ( $errors as $key => $error ) {
                    $this->addError( $key, implode(", ", $error) );
                }
            }
        }

    }
}
