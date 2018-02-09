<?php

namespace app\modules\api\models;

use Yii;
use app\models\User;
use yii\helpers\Json;
use app\models\Storage;
use yii\helpers\Url;


/**
 * This is the model class for table "access_keys".
 *
 * @property integer $id
 * @property string $expand
 * @property string $token
 * @property integer $expiry_date
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $user_id
 */
class AccessKey extends \yii\db\ActiveRecord
{
    const CREATE_CROWD_SESSION_URL = "/rest/usermanagement/1/session";
    const CHECK_CROWD_SESSION_URL = "/rest/usermanagement/1/session/";
    const CROWD_REQUEST = "/rest/usermanagement/1/authentication?username=";
    const AVATAR_REQUEST = "/rest/usermanagement/1/user/avatar?username=";
    const GROUP_FROM_CROWD = "/rest/usermanagement/1/user/group/direct?username=";
    const CHECK_USER_BY_EMAIL = "/rest/usermanagement/1/user?username=";


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_keys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expiry_date', 'user_id'], 'integer'],
            [['expand'], 'string', 'max' => 50],
            [['token'], 'string', 'max' => 250],
            [['email', 'first_name', 'last_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'expand'      => 'Expand',
            'token'       => 'Token',
            'expiry_date' => 'Expiry Date',
            'email'       => 'Email',
            'first_name'  => 'First Name',
            'last_name'   => 'Last Name',
            'user_id'     => 'User Id',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /*
     *check for valid crowd session
     */
    public static function checkCrowdSession($token)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => Yii::$app->params['crowd_domain'] . self::CHECK_CROWD_SESSION_URL . $token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "GET",
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
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    /*
     * create crowd session
     */
    public static function createCrowdSession($name, $pass)
    {
        $params = array(
            "username" => "$name",
            "password" => "$pass",
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => Yii::$app->params['crowd_domain'] . self::CREATE_CROWD_SESSION_URL,
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
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    /*
     * cut timestamp e.g "expiry-date":1513776619706 to 1513776619
     */
    public static function getExpireForSession($obj)
    {
        $sessionObjToArray = \yii\helpers\ArrayHelper::toArray($obj, [], false);
        return substr($sessionObjToArray['expiry-date'], 0, 10);
    }

    /*
     *create crowd session and write to access_keys table
     */
    public static function createAccessKey($email, $password, $userId, $obj)
    {
        $sessionObj = self::createCrowdSession($email, $password);
        $objToArray = \yii\helpers\ArrayHelper::toArray($obj, [], false);

        $exp = self::getExpireForSession($sessionObj);

        $accessKey = new AccessKey();
        $accessKey->expand      = $sessionObj->expand;
        $accessKey->token       = $sessionObj->token;
        $accessKey->expiry_date = $exp;
        $accessKey->email       = $obj->email;
        $accessKey->first_name  = $objToArray['first-name'];
        $accessKey->last_name   = $objToArray['last-name'];
        $accessKey->user_id     = $userId;
        $accessKey->save();
    }

    /*
     *function for authentication and check if user active in crowd
     */
    public static function toCrowd($email, $password)
    {
        $params = array(
            "value" => "$password",
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::$app->params['crowd_domain'] . self::CROWD_REQUEST . $email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => Json::encode($params),
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
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    /*
     *
     */
    public static function createUser($obj, $password)
    {
        $objToArray = \yii\helpers\ArrayHelper::toArray($obj, [], false);
        $newUser = new User();
        $newUser->role = User::ROLE_DEV;
        $newUser->first_name = $objToArray['first-name'];
        $newUser->last_name = $objToArray['last-name'];
        $newUser->email = $obj->email;
        $newUser->password = $password;
        $newUser->is_active = User::ACTIVE_USERS;
        $newUser->auth_type = User::CROWD_AUTH;
        $newUser->save();

        return $newUser;
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

    /*
     *
     */
    public static function getAvatarFromCrowd($email)
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
    }

    /*
     *
     */
    public static function refToGroupInCrowd($email)
    {
        $roleArr = [User::ROLE_DEV, User::ROLE_CLIENT, User::ROLE_PM, User::ROLE_FIN, User::ROLE_ADMIN];
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

        $response = curl_exec($curl);
        curl_close($curl);

        $array = json_decode($response,TRUE);
        $elem = array_shift($array['groups']);
        if(in_array($elem['name'], $roleArr)) {
            return $elem['name'];
        } else {
            return false;
        }

    }
    /*
     *
     */
    public static function changeUserRole($user, $roleInCrowd)
    {
        $user->role = $roleInCrowd;
        $user->save();
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
                $content = file_get_contents(AccessKey::findAddress($response,'found at '));
                $s = new Storage();
                $pathFile = 'data/' . Yii::$app->user->id . '/photo/';
                $s->uploadData($pathFile . 'avatar', $content);
            }
            catch (\Exception $e) {
            }

        }
    }

    /**
     * @param $email
     * @return bool
     */
    public static function checkUserByName($email) : bool
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::$app->params['crowd_domain'] . self::CHECK_USER_BY_EMAIL . $email,
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
            return "cURL Error #:" . $err;
        } else {
            $decode = json_decode($response);
           return isset($decode->reason) ? false : true;
        }
    }

    /**
     * @return mixed
     *  e.g "develop.skynix.co"
     */
    public static function getStringFromURL()
    {
       return Yii::$app->getRequest()->hostName;
    }

    /*
     *
     */
    public static function nameFromURL()
    {
       return str_replace( ".", "_", self::getStringFromURL());
    }

}
