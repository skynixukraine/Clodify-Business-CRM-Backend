<?php

namespace app\modules\api\models;

use Yii;
use yii\base\Model;
use app\modules\api\models\ApiAccessToken;
use app\models\LoginForm;
/**
 * ApiLoginForm is the model behind the login form used by API.
 */
class ApiLoginForm extends LoginForm
{
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->date_login = time();
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
                $clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) {
                $clientIpAddress = $_SERVER['REMOTE_ADDR'];
            }
            if (isset($clientIpAddress)) {
              //  $user->ip = $clientIpAddress;
            }

            $user->save();

            $accessToken = ApiAccessToken::find()->where(['user_id' => $user->id])->one();
            $date = date(strtotime("now +" . ApiAccessToken::EXPIRATION_PERIOD ));

            if( $accessToken ) {
                if ( strtotime( $accessToken->exp_date ) < strtotime("now -" . ApiAccessToken::EXPIRATION_PERIOD ) ) {
                    $accessToken->exp_date = date('Y-m-d H:i:s', $date);
                }
            } else {
                $accessToken = new ApiAccessToken();
                $accessToken->user_id = $user->id;
                $accessToken->access_token = Yii::$app->security->generateRandomString();
                $accessToken->exp_date = date('Y-m-d H:i:s', $date);

            }
            $accessToken->save();
            return $accessToken;
        } else {
            return false;
        }
    }
}