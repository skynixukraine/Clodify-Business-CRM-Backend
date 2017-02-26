<?php
/**
 * Created by Skynix Team
 * Date: 26.02.17
 * Time: 14:16
 */

namespace viewModel;


use app\models\User;

class Password extends ViewModelAbstract
{
    /** @var  \app\models\User */
    public $model;

    public function define()
    {

        if ($this->validate()) {
            $user = User::findOne(['email' => $this->model->email]);
            $user->rawPassword = User::generatePassword();
            $user->password = md5($user->rawPassword);
            $user->save();
        }

    }
}