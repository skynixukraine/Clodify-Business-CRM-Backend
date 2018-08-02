<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 20.12.17
 * Time: 15:52
 */

namespace app\components;


use app\models\User;
use PhpMyAdmin\MoTranslator\Loader;
use Yii;
use yii\base\Component;
use app\modules\api\models\AccessKey;
use yii\helpers\Json;
use app\models\Storage;
use yii\log\Logger;

class CrowdComponent extends Component
{

    const CODE_NOT_FOUND    = 404;
    const CODE_SUCCESS      = 200;

    const CROWD_SESSION_URL = "/rest/usermanagement/1/session";

    const CROWD_REQUEST = "/rest/usermanagement/1/authentication?username=";
    const AVATAR_REQUEST = "/rest/usermanagement/1/user/avatar?username=";
    const GROUP_FROM_CROWD = "/rest/usermanagement/1/user/group/direct?username=";
    const CHECK_USER_BY_EMAIL = "/rest/usermanagement/1/user?username=";


    public function getMessageFromCrowd($obj)
    {
        // {"reason":"USER_NOT_FOUND","message":"User <email@skynix.co> does not exist"}
        return $obj->message . " in Crowd";
    }


    /**
     * Validate & Prolong Session
     * @param $token
     * @return array
     */
    public static function validateCrowdSession( $token )
    {
        $dataResponse = [
            'expand'        => null,
            'success'       => true,
            'reason'        => false,
            'token'         => null,
            'expiryDate'    => null,
            'createdDate'   => null
        ];
        if ( !$token ) {

            $dataResponse['success']    = false;
            $dataResponse['reason']     = "Undefined token";
            return $dataResponse;

        }
        $curl = curl_init();
        $params = array(
            "validationFactors" => [
                [
                    "name"  => "remote_address",
                    "value" => Yii::$app->getRequest()->getUserIP()
                ]
            ],
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL            => Yii::$app->params['crowd_domain'] . self::CROWD_SESSION_URL . '/' . $token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => Json::encode($params),
            CURLOPT_HTTPHEADER     => array(
                "accept: application/json",
                "authorization:" . Yii::$app->params['crowd_code'],
                "content-type: application/json",
            ),
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {

            $dataResponse['success']    = false;
            $dataResponse['reason']     = $err;

        } else {

            $response = json_decode($response, true);
            if ( !isset($response['reason'])) {

                $dataResponse['token']      = $response['token'];
                $dataResponse['expiryDate'] = self::getExpireForSession($response['expiry-date']);
                $dataResponse['createdDate']= $response['created-date'];
                $dataResponse['user']       = $response['user'];

            } else {

                $dataResponse['success']    = false;
                $dataResponse['reason']     = $response['message'];
            }
        }
        return $dataResponse;
    }

    /**
     * create crowd session
     * @param $name
     * @param $pass
     * @return array
     */
    public static function createCrowdSession($name, $pass)
    {
        $params = array(
            "username" => "$name",
            "password" => "$pass",
            "validation-factors" => [

                "validationFactors" => [
                    [
                        "name"  => "remote_address",
                        "value" => Yii::$app->getRequest()->getUserIP()
                    ]
                ],

            ]
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => Yii::$app->params['crowd_domain'] . self::CROWD_SESSION_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => Json::encode($params),
            CURLOPT_HTTPHEADER     => array(
                "accept: application/json",
                "authorization:" . Yii::$app->params['crowd_code'],
                "content-type: application/json",
            ),
        ));

        $dataResponse = [
            'expand'        => null,
            'success'       => true,
            'reason'        => false,
            'token'         => null,
            'expiryDate'    => null,
            'createdDate'   => null
        ];
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {

            $dataResponse['success']  = false;
            $dataResponse['reason']   = $err;

        } else {

            $response = json_decode($response, true);
            if ( !isset($response['reason'])) {

                $dataResponse['expand']     = $response['expand'];
                $dataResponse['token']      = $response['token'];
                $dataResponse['expiryDate'] = self::getExpireForSession($response['expiry-date']);
                $dataResponse['createdDate']= $response['created-date'];

            } else {

                $dataResponse['success']    = false;
                $dataResponse['reason']     = $response['message'];
            }
        }
        return $dataResponse;
    }

    /**
     * cut timestamp e.g "expiry-date":1513776619706 to 1513776619
     * @param $exp
     * @return bool|string
     */
    public static function getExpireForSession($exp)
    {
        return (int)substr($exp, 0, 10);
    }

    /**
     * function for authentication and check if user active in crowd
     * @param $email
     * @param $password
     * @return array
     */
    public static function authenticateToCrowd($email, $password)
    {
        $params = array(
            "value" => "$password",
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL             => Yii::$app->params['crowd_domain'] . self::CROWD_REQUEST . $email,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => Json::encode($params),
            CURLOPT_HTTPHEADER      => array(
                "accept: application/json",
                "authorization:" . Yii::$app->params['crowd_code'],
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $returnData = [
            'success'   => false,
            'errors'    => [],
            'user'      => null
        ];
        if ($err) {

            $returnData['errors'][]  = "cURL Error #:" . $err;

        } elseif (($data = json_decode($response, true))) {

            if ( isset($data['reason']) ) {

                $returnData['errors'][] = $data['message'];

            } else {

                $returnData['success']  = true;
                $returnData['user']     = $data;
            }

        } else {

            $returnData['errors'][] = Yii::t("app", "Crowd response error");

        }
        return $returnData;

    }

    /*
     *
     */
    /*public static function getAvatarFromCrowd($email)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::$app->params['crowd_domain'] . self::AVATAR_REQUEST . $email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization:" . Yii::$app->params['crowd_code'],
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $j = json_decode($response);
            if(isset($j->reason)){
                return "/img/avatar.png";
            } else {
                return self::findAddress($response,'found at ');
            }
        }
    }*/

    /**
     * @param $email
     * @return array
     */
    public static function refToGroupInCrowd($email)
    {
        $roleArr = [User::ROLE_SALES, User::ROLE_DEV, User::ROLE_CLIENT, User::ROLE_PM, User::ROLE_FIN, User::ROLE_ADMIN, User::ROLE_GUEST];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::$app->params['crowd_domain'] . self::GROUP_FROM_CROWD . $email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization:" . Yii::$app->params['crowd_code'],
                "content-type: application/json",
            ),
        ));

        $response       = curl_exec($curl);
        $info           = curl_getinfo($curl);
        $returnData     = [
            'success'   => false,
            'code'      => $info['http_code'],
            'role'      => null
        ];
        if ( ($error = curl_error($curl)) || $info['http_code'] != self::CODE_SUCCESS ) {

            Yii::getLogger()->log( "CROWD refToGroupInCrowd Error: " . $error . var_export($info, 1), Logger::LEVEL_WARNING);

        } else {

            $array = json_decode($response,TRUE);
            $elem = array_shift($array['groups']);
            $returnData['success']  = true;
            if(in_array($elem['name'], $roleArr)) {
                $returnData['role']     = $elem['name'];
            }

        }
        curl_close($curl);
        return $returnData;
    }

    /*
     *
     */
    public static function putAvatarInAm($email)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::$app->params['crowd_domain'] . self::AVATAR_REQUEST . $email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization:" . Yii::$app->params['crowd_code'],
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            try {
                $content = file_get_contents(self::findAddress($response,'found at '));
                $s = new Storage();
                $pathFile = 'users/' . Yii::$app->user->id . '/photo/';
                $s->uploadData($pathFile . 'avatar', $content);
            }
            catch (\Exception $e) {

                Yii::getLogger()->log( "CROWD Error: " . $e->getMessage(), Logger::LEVEL_WARNING);
            }

        }
    }


    /*
     * return string(url of the avatar image) after specified substring
     */
    public static function findAddress($string, $substring) {
        $pos = strpos($string, $substring);
        if ($pos === false)
            return $string;
        else
            return strval(substr($string, $pos+strlen($substring)));
    }
}
