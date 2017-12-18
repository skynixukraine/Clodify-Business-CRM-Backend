<?php

namespace app\modules\api\models;

use Yii;
use yii\base\Model;
use app\modules\api\models\ApiAccessToken;
use app\models\LoginForm;
use yii\helpers\Json;
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
        $user->date_login = date('Y-m-d H:i:s');

        /*if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) {
            $clientIpAddress = $_SERVER['REMOTE_ADDR'];
        }
        if (isset($clientIpAddress)) {
          //  $user->ip = $clientIpAddress;
        }*/
        

        if( !($accessToken = ApiAccessToken::find()->where(['user_id' => $user->id])->one()) ||
            ( ( strtotime( $accessToken->exp_date ) < strtotime("now -" . ApiAccessToken::EXPIRATION_PERIOD ) ) ) ) {

            $accessToken = ApiAccessToken::generateNewToken( $user );

        }
        $user->save(false, ['date_login']);
        return $accessToken;

    }

    /*
     * request for user authentication in crowd
     */
    public function toCrowd()
    {

        $params = array(
            "value" => "$this->password",
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://crowd-01.skynix.co/crowd/rest/usermanagement/1/authentication?username=" . $this->email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => Json::encode($params),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Basic c2t5bml4Y3JtOml5Yk05UXFuVUNoNlpfNWE4UEpOQkF2NGt1Y0tYZA==",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    /*  request for creating session in crowd
     *
     */
    public static function createCrowdSession($name, $pass)
    {
        $params = array(
            "username" => "$name",
            "password" => "$pass",
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://crowd-01.skynix.co/crowd/rest/usermanagement/1/session",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => Json::encode($params),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Basic c2t5bml4Y3JtOml5Yk05UXFuVUNoNlpfNWE4UEpOQkF2NGt1Y0tYZA==",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    /*
     * get "expiry-date":1513607801052, cut it to 1513607801(current date)
     *
     */
    public static function getExpireForSession($obj)
    {
        $sessionObjToArray = json_decode(json_encode($obj), true);
        return substr($sessionObjToArray['expiry-date'], 0, 10);
    }
}