<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use app\models\ContactForm;
use app\models\User;
use Yii;

class Contacts extends ViewModelAbstract
{
    /** @var  \app\models\ContactForm */
    public $model;

    public function define()
    {

        if ($this->validate() && ($reciever = User::findOne(Yii::$app->params['contractorId']))) {
            $secret = Yii::$app->params['captchaSecret'];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                "secret={$secret}&response={$this->model->verifyCode}");
            $server_output = curl_exec ($ch);

            curl_close ($ch);

            // The response is a JSON object:
            $server_output = json_decode($server_output);
            if ($server_output['success']) {
                $this->model->contact($reciever->email);
            }
        }

    }

}
