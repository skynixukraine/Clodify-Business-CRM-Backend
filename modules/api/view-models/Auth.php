<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use Yii;
use app\models\User;
use app\modules\api\models\ApiLoginForm;
use app\modules\api\components\Api\Processor;


class Auth extends ViewModelAbstract
{

    /** @var  \app\models\User */
    public $model;

    public function define()
    {
        $this->model->scenario = 'api-login';

        if($this->validate()) {
            $loginForm = new ApiLoginForm();
            $loginForm->email       = $this->model->email;
            $loginForm->password    = $this->model->password;
            $this->model            = $loginForm;

            // crowd session code go here
            $var = Yii::$app->crowdComponent->checkByEmailPassword($loginForm->email, $loginForm->password);
            if(isset($var['error'])){
                $this->addError(Processor::CROWD_ERROR_PARAM, Yii::t('yii', $var['error']));
            }

           if ($this->validate() && ($token = $this->model->login())) {
               $user = User::findOne(['id' => $token->user_id]);
               $this->setData([
                   'access_token' => $token->access_token,
                   'user_id' => $token->user_id,
                   'role' => $user->role
               ]);
           }
        }
    }

}
