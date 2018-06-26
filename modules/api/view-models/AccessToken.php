<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 21:31
 */

namespace viewModel;

use Yii;
use app\modules\api\models\ApiAccessToken;
use app\models\User;
use app\modules\api\components\Api\Processor;
use app\modules\api\models\ApiLoginForm;

class AccessToken extends ViewModelAbstract
{

    /** @var  \app\models\User */
    public $model;

    public function define()
    {
        $userId = Yii::$app->request->get("user_id");
        if ( !User::hasPermission([User::ROLE_ADMIN]) ) {
            return $this->addError(Processor::ERROR_PARAM, 'Only admin can login as another users');
        }

        if ( $userId && ($user = $this->model->findOne($userId)) ) {
            if( ($token = ApiAccessToken::generateNewToken($user) ) && $token->save()) {
                $this->setData([
                    'access_token' => $token->access_token
                ]);
            }
        } else {
            return $this->addError('user_id', 'Such user is not existed');
        }

    }
}
