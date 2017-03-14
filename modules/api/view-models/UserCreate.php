<?php
/**
 * Created by Skynix Team
 * Date: 13.03.17
 * Time: 15:34
 */

namespace viewModel;

use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Create user request
 * @see https://confluence.skynix.company/pages/viewpage.action?spaceKey=SKYN&title=Skynix+CRM+-+RESTful+API+Specification#SkynixCRM-RESTfulAPISpecification-2.2.3CreateUserRequest
 * Class UserCreate
 * @package viewModel
 */

class UserCreate extends ViewModelAbstract
{
    /**
     * Create new user
     * Admin should be able create new user with new email
     * Admin should be able to create a new user with the email of deleted user
     */
    public function define()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) ) {
            $user = User::findOne(['email' => $this->model->email]);

            $this->model->password = User::generatePassword();
            /** Create a new user with the email of deleted user */
            if(!empty($user) && $user->is_delete == 1) {
                $this->model = $user;
                $this->model->is_active        = 0;
                $this->model->invite_hash      = md5(time());
                $this->model->rawPassword      = $this->model->password;
                $this->model->password         = md5($user->rawPassword);
                $this->model->date_signup      = date('Y-m-d H:i:s');
            }

            if ($this->validate()) {
                $this->model->is_delete = 0;
                /** Create new user*/
                $this->model->save();
            }
    } else {
            $this->addError(Processor::ERROR_PARAM, Yii::t('app','You don\'t have permissions. Only admin can create users.'));
        }
    }
}