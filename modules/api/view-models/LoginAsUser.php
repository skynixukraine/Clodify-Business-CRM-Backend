<?php
/**
 * Created by Skynix Team
 * Date: 7/11/18
 * Time: 21:31
 */

namespace viewModel;

use app\modules\api\models\ApiAccessToken;
use Yii;
use app\models\User;
use app\modules\api\models\ApiLoginForm;
use app\modules\api\components\Api\Processor;


class LoginAsUser extends ViewModelAbstract
{

    /** @var  \app\models\User */
    public $model;
    public $token;

    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {
            $id = Yii::$app->request->getQueryParam('user_id');

            if ($id && $this->model = $this->model->findOne($id)) {
                $this->model->scenario = 'api-login';

                $loginForm = new ApiLoginForm();
                $loginForm->email       = $this->model->email;
                $this->model            = $loginForm;

                if ( $this->validate() ) {

                    /** @var $token ApiAccessToken */
                    if ( ( $token = $this->model->login() ) ) {

                        $this->setData([
                            'access_token'  => $token->access_token,
                            'user_id'       => $token->user_id,
                            'role'          => User::findOne( $token->user_id )->role,
                            'crowd_token'   => $token->crowd_token
                        ]);
                    }
                }
            }
            else{
                return $this->addError(Processor::ERROR_PARAM, 'The user does not exist');
            }
        }

        else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }

    }

}
