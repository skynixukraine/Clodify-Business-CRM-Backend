<?php
/**
 * Created by Skynix Team
 * Date: 26.02.17
 * Time: 14:16
 */

namespace viewModel;


use app\models\User;
use Yii;

class Password extends ViewModelAbstract
{
    /** @var  \app\models\User */
    public $model;

    public function define()
    {

        if ($this->validate()) {
            // captcha block
            $secret = Yii::$app->params['captchaSecret'];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                "secret={$secret}&response={$this->model->captcha}");
            $server_output = curl_exec ($ch);

            curl_close ($ch);
            // The response is a JSON object:
            $server_output = json_decode($server_output);
            $errors = 'error-codes';
            if ($server_output->success) {
                // changing password
                $user = User::findOne(['email' => $this->model->email]);
                $user->rawPassword = User::generatePassword();
                $user->password = md5($user->rawPassword);
                $user->save();
            } else {
                $this->addError('captcha', implode(', ',(array) $server_output->$errors));
            }
        }

    }
}