<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 20.12.17
 * Time: 15:52
 */

namespace app\components;


use Yii;
use yii\base\Component;
use app\modules\api\models\AccessKey;
use app\modules\api\models\ApiAccessToken;
use app\models\User;


class CrowdComponent extends Component
{

    public function checkByAccessToken($accessToken, $checkAccess = true)
    {
        $errorArr = [];
        $accessTokenModel = ApiAccessToken::findOne(['access_token' => $accessToken ] );

        $crowdInfo = AccessKey::findOne(['user_id' => $accessTokenModel->user_id]);

        if($crowdInfo){
            $crowdSession = AccessKey::checkCrowdSession($crowdInfo->token);
            if(isset($crowdSession->reason)){
                $errorArr['error'] = $crowdSession->reason . ' You have to authenticate with email and password!';
            }
            if(isset($crowdSession->active) && !$crowdSession->active){
                $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
            }
        } elseif ($checkAccess == true ) {
            $errorArr['error'] = 'You have to authenticate with email and password';
        }

        return $errorArr;
    }

    public function checkByEmailPassword($email, $password)
    {
        $errorArr = [];
        $obj = AccessKey::toCrowd($email, $password);

        if(!isset($obj->reason)) {     // if element 'reason' exist, some autentication error there in crowd

            $objToArray = json_decode(json_encode($obj), true);

            if ($obj->active) {
                $user = User::findOne(['email' => $email]);
                $accesKey = AccessKey::findOne(['email' => $obj->email]);

                if (!$user) {
                    //create user and write to access_keys with new user
                    $newUser = new User();
                    $newUser->role       = User::ROLE_DEV;
                    $newUser->first_name = $objToArray['first-name'];
                    $newUser->last_name  = $objToArray['last-name'];
                    $newUser->email      = $obj->email;
                    $newUser->password   = $password;
                    $newUser->save();
                    AccessKey::createAccessKey($email, $password, $newUser->id, $obj);
                } elseif(!$accesKey && $user) {
                    // write to access_keys with existed user
                    AccessKey::createAccessKey($email, $password, $user->id, $obj);
                } elseif($accesKey) {
                    // create crowd session
                    $session = AccessKey::checkCrowdSession($accesKey->token);
                    if(isset($session->reason)){
                        $newSession = AccessKey::createCrowdSession($email, $password);
                        AccessKey::updateAll(['token' => $newSession->token, 'expiry_date' => AccessKey::getExpireForSession($newSession)],
                            ['user_id' => $accesKey->user_id, 'email' => $email]);
                    }
                }
            } else {
                $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
            }
        } else {
            $errorArr['error'] = $obj->reason;
        }
        return $errorArr;
    }

    public function checkByEmailPasswordCRM($email, $password)
    {
        $errorArr = [];
        $obj = AccessKey::toCrowd($email, $password);
        if(!isset($obj->reason)) {     // if element 'reason' exist, some autentication error there in crowd

            if ($obj->active) {

                if(isset($_COOKIE[User::READ_COOKIE_NAME])) {

                    $session = AccessKey::checkCrowdSession($_COOKIE[User::READ_COOKIE_NAME]);
                    if(isset($session->reason)){
                        $this->createCrowdSessionAndCookie($email, $password);
                    }
                } else {
                    $this->createCrowdSessionAndCookie($email, $password);
                }

            } else {
                $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
            }
        } else {
            $errorArr['error'] = $obj->reason;
        }
        return $errorArr;
    }

    private function createCrowdSessionAndCookie($email, $password)
    {
        $path = "/";
        $domain = ".skynix.co";
        $newSession = AccessKey::createCrowdSession($email, $password);
        setcookie(User::CREATE_COOKIE_NAME, $newSession->token, AccessKey::getExpireForSession($newSession), $path, $domain);
    }

}