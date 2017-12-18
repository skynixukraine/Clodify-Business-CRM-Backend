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
use app\modules\api\models\ApiLoginForm;
use app\modules\api\components\Api\Processor;


class Auth extends ViewModelAbstract
{

    /** @var  \app\models\User */
    public $model;

    public function define()
    {
        $this->model->scenario = 'api-login';

        if($this->validate()) {
            $loginForm = new ApiLoginForm();
            $loginForm->email       = $this->model->email;
            $loginForm->password    = $this->model->password;
            $this->model            = $loginForm;

            $obj = $this->model->toCrowd();
            if(!isset($obj->reason)){     // if element 'reason' exist, some autentication error there in crowd

            $objToArray = json_decode(json_encode($obj), true);

            if($obj->active){
                $user = User::findOne(['email' => $loginForm->email]);
                if(!empty($user)) {
                    $sessionObj = ApiLoginForm::createCrowdSession($loginForm->email, $loginForm->password);
                    $exp = ApiLoginForm::getExpireForSession($sessionObj);
                } else{
                    $newUser = new User();
                    $newUser->role = User::ROLE_DEV;
                    $newUser->first_name = $objToArray['first-name'];
                    $newUser->last_name = $objToArray['last-name'];
                    $newUser->email = $obj->email;
                    $newUser->password = $loginForm->password;
                    $newUser->save();
                    $sessionObj = ApiLoginForm::createCrowdSession($newUser->email, $newUser->password);
                    $exp = ApiLoginForm::getExpireForSession($sessionObj);
                }
                $this->setData([
                    'expand' => $sessionObj->expand,
                    'token' => $sessionObj->token,
                    'expiry-date' => $exp,
                ]);

            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Your account is suspended, contact Skynix administrator'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii',  $obj->reason . ' Your username or password is wrong. Use your skynix credentials'));
        }

        }
    }

}
