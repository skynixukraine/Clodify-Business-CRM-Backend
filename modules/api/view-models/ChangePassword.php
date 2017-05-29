<?php
/**
 * Created by Skynix Team
 * Date: 05.04.17
 * Time: 9:41
 */

namespace viewModel;

use app\models\User;
use Yii;
use app\modules\api\models\ApiLoginForm;

/**
 * Class ChangePassword
 * @package viewModel
 */
class ChangePassword extends ViewModelAbstract
{
    /** @var  \app\models\User */
    public $model;

    public function define()
    {
        if (is_string($this->model->code)) {
            $user = User::findOne([
                'is_delete' => 0,
                'password_reset_token' => $this->model->code,
            ]);

            if (!$user) {
                return $this->addError('code', "Code is not valid or expired.");
            } else {
                $user->rawPassword = User::generatePassword();
                $user->password_reset_token = null;
                if ($user->save()) {
                    $loginForm = new ApiLoginForm();
                    $loginForm->email = $user->email;
                    $loginForm->password = $user->password;
                    $loginForm->login();
                }
            }

        } else {
            $this->addError('code', "Code must be a string.");
        }

    }

}