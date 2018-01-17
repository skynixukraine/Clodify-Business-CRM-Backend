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

    public function checkByAccessToken($accessToken)
    {
        $errorArr = [];
        $accessTokenModel = ApiAccessToken::findOne(['access_token' => $accessToken ] );

        $crowdInfo = AccessKey::findOne(['user_id' => $accessTokenModel->user_id]);
        $user= User::findOne($accessTokenModel->user_id);

        if($crowdInfo){
            $crowdSession = AccessKey::checkCrowdSession($crowdInfo->token);
            if(isset($crowdSession->reason)){
                $errorArr['error'] = $crowdSession->reason . ' You have to authenticate with email and password!';
            }
            if(isset($crowdSession->active) && !$crowdSession->active){
                if ($user){
                    User::deactivateUser($user);
                }
                $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
            }
        } else {
            if($user->is_active && !$user->is_delete){
                return true;
            } else {
                $errorArr['error'] = 'No user is registered with this credentials';
            }
        }

        return $errorArr;
    }

    public function checkByEmailPassword($email, $password)
    {
        $errorArr = [];
        $obj = AccessKey::toCrowd($email, $password);
        $user = User::findOne(['email' => $email]);

        if($obj &&!isset($obj->reason)) {     // if element 'reason' exist, some autentication error there in crowd

            if ($obj->active) {
                $accesKey = AccessKey::findOne(['email' => $obj->email]);

                if (!$user) {
                    //create user and write to access_keys with new user
                    $newUser = AccessKey::createUser($obj, $password);

                    AccessKey::createAccessKey($email, $password, $newUser->id, $obj);
                } else {     // if user exist pickup role from crowd and synchronize
                    $roleInCrowd = AccessKey::refToGroupInCrowd($email);
                    if ($roleInCrowd && $user->role !== $roleInCrowd)
                    {
                        AccessKey::changeUserRole($user, $roleInCrowd);
                    }
                }

                if (!$accesKey && $user) {
                    // write to access_keys with existed user
                    AccessKey::createAccessKey($email, $password, $user->id, $obj);
                }

                if ($accesKey) {
                    // create crowd session
                    $session = AccessKey::checkCrowdSession($accesKey->token);
                    if (isset($session->reason)) {
                        $newSession = AccessKey::createCrowdSession($email, $password);
                        AccessKey::updateAll(['token' => $newSession->token, 'expiry_date' => AccessKey::getExpireForSession($newSession)],
                            ['email' => $email]);
                    }
                }

                AccessKey::putAvatarInAm($email);

            } else {
                if ($user){
                    User::deactivateUser($user);
                }
                $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
            }
        } else {
            if($user->is_active && !$user->is_delete){
                return true;
            } else {
                $errorArr['error'] = 'No user is registered with this credentials';
            }
        }
        return $errorArr;
    }

    public function checkByEmailPasswordCRM($email, $password)
    {
        $errorArr = [];

        $user = User::findOne(['email' => $email]);
        $obj = AccessKey::toCrowd($email, $password);

        if($obj && !isset($obj->reason)) {     // if element 'reason' exist, some autentication error there in crowd

            if (isset($obj->active) && $obj->active) {

                if (!$user) {
                    AccessKey::createUser($obj, $password);
                } else {  // if user exist pickup role from crowd and synchronize
                    $roleInCrowd = AccessKey::refToGroupInCrowd($email);
                    if ($roleInCrowd && $user->role !== $roleInCrowd) {
                         AccessKey::changeUserRole($user, $roleInCrowd);
                     }
                }

                if(isset($_COOKIE[User::READ_COOKIE_NAME])) {

                    $session = AccessKey::checkCrowdSession($_COOKIE[User::READ_COOKIE_NAME]);
                    if(isset($session->reason)){
                        $this->createCrowdSessionAndCookie($email, $password);
                    }
                } else {

                    $this->createCrowdSessionAndCookie($email, $password);
                }

                AccessKey::putAvatarInAm($email);

            } else {
                if ($user){
             //    User::deactivateUser($user);
                    $this->createCookie();
                } else {
                    $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
                }
            }
        } else {
            if ($user->is_active){
                // easy login with database
                // set cookies about auth with database
                $this->createCookie();
            }
        }
        return $errorArr;
    }

    private function createCrowdSessionAndCookie($email, $password)
    {
        $path = "/";
        $domain = ".skynix.co";
        $newSession = AccessKey::createCrowdSession($email, $password);
        setcookie(User::CREATE_COOKIE_NAME, $newSession->token, AccessKey::getExpireForSession($newSession), $path, $domain);
        // delete db authorization cookie
        setcookie(User::COOKIE_DATABASE, 'authorized_through_database',time()-3600*60, $path, $domain);

    }


    public function createCookie()
    {
        $path = "/";
        $domain = ".skynix.co";
        setcookie(User::COOKIE_DATABASE, 'authorized_through_database',time()+(60*10), $path, $domain);
        //delete crowd cookie
        setcookie(User::CREATE_COOKIE_NAME,"",time()-3600*60, $path, $domain);

    }
}