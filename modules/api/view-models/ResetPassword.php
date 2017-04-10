<?php
/**
 * Created by Skynix Team
 * Date: 03.04.17
 * Time: 12:52
 */

namespace viewModel;

use app\models\User;
use Yii;

/**
 * Class ResetPassword
 * @package viewModel
 */
class ResetPassword extends ViewModelAbstract
{
    /** @var  \app\models\User */
    public $model;

    public function define()
    {
        if ($this->validate()) {

            $user = User::findOne([
                'is_delete' => 0,
                'email' => $this->model->email,
            ]);
            if (!$user) {
                $this->addError('user', "User not found");
            } else {
                if (!$user->getPasswordResetToken()) {
                    $user->generatePasswordResetToken();
                    $user->save();
                }
                $mail = Yii::$app->mailer->compose('resetPassword', [
                    'username' => $user->first_name,
                    'token' => $user->getPasswordResetToken()
                ])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($user->email)
                    ->setSubject('Skynix CRM: Change password');

                if (!$mail->send()) {
                    $this->addError('email', "Email send error");
                }
            }
        }
    }

}