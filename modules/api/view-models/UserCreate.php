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
            if ($this->validate()) {
                /** Create new user*/
                $this->model->save();
            }
    } else {
            $this->addError(Processor::ERROR_PARAM, Yii::t('app','You don\'t have permissions. Only admin can create users.'));
        }
    }
}