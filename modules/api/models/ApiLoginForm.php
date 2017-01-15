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
    /**
     * This function generates/returns access token by passed email/password pair
     * @return \app\modules\api\models\ApiAccessToken|array|null|\yii\db\ActiveRecord
     */
    public function login()
    {
        $user = $this->getUser();
        $user->date_login = time();

        /*if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) {
            $clientIpAddress = $_SERVER['REMOTE_ADDR'];
        }
        if (isset($clientIpAddress)) {
          //  $user->ip = $clientIpAddress;
        }*/

        $user->save(false, ['date_login']);

        if( !($accessToken = ApiAccessToken::find()->where(['user_id' => $user->id])->one()) ||
            ( ( strtotime( $accessToken->exp_date ) < strtotime("now -" . ApiAccessToken::EXPIRATION_PERIOD ) ) ) ) {

            $accessToken = ApiAccessToken::generateNewToken( $user );

        }
        return $accessToken;

    }
}