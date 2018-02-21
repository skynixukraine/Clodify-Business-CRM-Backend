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
    public $token;

    public function define()
    {
        $this->model->scenario = 'api-login';

        if ($this->validate()) {
            $loginForm = new ApiLoginForm();
            $loginForm->email = $this->model->email;
            $loginForm->password = $this->model->password;
            $this->model = $loginForm;

            $user = $this->model->getUser();
            if ($user->auth_type == User::CROWD_AUTH) {

                $checkUser = Yii::$app->crowdComponent->checkByEmailPassword($loginForm->email, $loginForm->password);
                if (isset($checkUser['error'])) {
                    $this->addError(Processor::CROWD_ERROR_PARAM, Yii::t('yii', $checkUser['error']));
                }

                if (!is_array($checkUser)) {
                    $this->token = $this->model->login();
                }
            }

            if ($user->auth_type == User::DATABASE_AUTH) {
                if ($this->validate()) {
                    $this->token = $this->model->login();
                }
            }

            if (isset($this->token)) {
                $this->setData([
                    'access_token' => $this->token->access_token,
                    'user_id' => $this->token->user_id,
                    'role' => $user->role
                ]);
            }
        }
    }

}
