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
    /**
     * @param $accessToken
     * @return array|bool
     */
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

    /**
     * @param $email
     * @param $password
     * @return array|bool
     */
    public function checkByEmailPassword($email, $password)
    {
        $errorArr = [];
        $user = User::findOne(['email' => $email]);

        if ($user) {
            if ($user->auth_type == User::CROWD_AUTH) {
                $obj = AccessKey::toCrowd($email, $password);

                if($obj && $this->validCrowdUser($obj)) {   // if element 'reason' exist, some authentication error there in crowd

                        $accesKey = AccessKey::findOne(['email' => $obj->email]);
                        if ($accesKey) {
                            // create crowd session
                            $session = AccessKey::checkCrowdSession($accesKey->token);
                            if (isset($session->reason)) {
                                $newSession = AccessKey::createCrowdSession($email, $password);
                                AccessKey::updateAll(['token' => $newSession->token, 'expiry_date' => AccessKey::getExpireForSession($newSession)],
                                    ['email' => $email]);
                            }

                        } else {
                            // write to access_keys with existed user
                            AccessKey::createAccessKey($email, $password, $user->id, $obj);
                        }
                } else {
                    $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
                }
            }  //elseif(check for another auth type){}

        } else {

            $obj = AccessKey::toCrowd($email, $password);
            if($obj && $this->validCrowdUser($obj)) {     // if element 'reason' exist, some autentication error there in crowd
                    AccessKey::createUser($obj, $password);
            } else {
                $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
            }
        }

        return !empty($errorArr) ? $errorArr : true;
    }

    /**
     * @param $email
     * @param $password
     * @return array|bool
     */
    public function checkByEmailPasswordCRM($email, $password)
    {
        $errorArr = [];

        $user = User::findOne(['email' => $email]);

        if ($user){
            if($user->auth_type == User::CROWD_AUTH){
                $obj = AccessKey::toCrowd($email, $password);

                if($obj && $this->validCrowdUser($obj)) {
//                        $roleInCrowd = AccessKey::refToGroupInCrowd($email);
//                        if ($roleInCrowd && $user->role !== $roleInCrowd) {
//                            AccessKey::changeUserRole($user, $roleInCrowd);
//                        }
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

            } elseif($user->auth_type == User::DATABASE_AUTH){
                $this->createCookie();
            }       // another auth types

        } else {
            $obj = AccessKey::toCrowd($email, $password);
            if($obj && $this->validCrowdUser($obj)) {     // if element 'reason' exist, some autentication error there in crowd
                        AccessKey::createUser($obj, $password);
            } else {
                $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
            }
        }
        return !empty($errorArr) ? $errorArr : true;
    }

    /**
     * @param $obj
     * @return bool
     */
    public function validCrowdUser($obj)
    {
        if (!isset($obj->reason) && isset($obj->active) && $obj->active) {     // if element 'reason' exist, some autentication error there in crowd
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $email
     * @param $password
     */
    private function createCrowdSessionAndCookie($email, $password)
    {
        $path = "/";
        $domain = ".skynix.co";
        $newSession = AccessKey::createCrowdSession($email, $password);
        setcookie(User::CREATE_COOKIE_NAME, $newSession->token, AccessKey::getExpireForSession($newSession), $path, $domain);

        // delete db authorization cookie
        setcookie(User::COOKIE_DATABASE, 'authorized_through_database',time()-3600*60, $path, $domain);

    }

    /**
     *
     */
    public function createCookie()
    {
        $path = "/";
        $domain = ".skynix.co";
        setcookie(User::COOKIE_DATABASE, 'authorized_through_database',time()+(60*30), $path, $domain);
        //delete crowd cookie
        setcookie(User::CREATE_COOKIE_NAME,"",time()-3600*60, $path, $domain);

    }

    /**
     * @param $session
     */
    public function prolongCrowdCookie($session)
    {
        $path = "/";
        $domain = ".skynix.co";

        // get difference beetwen create and expiry date of the crowd session instead of hardcode 30 min
        $sessionObjToArray = \yii\helpers\ArrayHelper::toArray($session, [], false);
        $created = substr($sessionObjToArray['created-date'], 0, 10);
        $sessionObjToArray = \yii\helpers\ArrayHelper::toArray($session, [], false);
        $expiry = substr($sessionObjToArray['expiry-date'], 0, 10);
        $dateDiff = $expiry - $created;

        // set crowd.token_key cookie with value of current crowd token and expiry extended by expiry crowd date difference(30 min)
        setcookie(User::CREATE_COOKIE_NAME, $_COOKIE[User::READ_COOKIE_NAME],time() + $dateDiff, $path, $domain);

    }
}