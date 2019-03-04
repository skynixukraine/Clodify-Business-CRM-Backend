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

            if ($id && ($user = $this->model->findOne($id)) &&
                ($accessToken = ApiAccessToken::generateNewToken($user)) ) {

                $accessToken->save(false);
                $this->setData([
                    'access_token'  => $accessToken->access_token,
                    'user_id'       => $accessToken->user_id,
                    'role'          => $user->role,
                    'crowd_token'   => $accessToken->crowd_token
                ]);
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
