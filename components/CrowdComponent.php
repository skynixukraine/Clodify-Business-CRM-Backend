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
use yii\log\Logger;


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
            if($crowdSession['isSuccess'] === false){
                Yii::getLogger()->log( "CROWD: " . $accessToken . ": crowd session died: " . $crowdSession['reason'], Logger::LEVEL_INFO);
                $errorArr['error'] = $crowdSession['reason'] . ' You have to authenticate with email and password!';
            } elseif ( ($crowdSession['expiryDate'] - time()) < 1000 )  {

                $newSession = AccessKey::validateCrowdSession($crowdSession['token']);
                Yii::getLogger()->log( "CROWD: " . $accessToken . ": crowd session validated: " .
                    "old token: " . $crowdSession['token'] .
                    "new token: " . $newSession['token'] .
                    "old exp: " . $crowdSession['expiryDate'] .
                    "new exp: " . $newSession['expiryDate'], Logger::LEVEL_INFO);

                $accessTokenModel->exp_date = $newSession['expiryDate'];
                $accessTokenModel->save(false, ['exp_date']);

            }
            /*
             *
             * How this can work? https://docs.atlassian.com/atlassian-crowd/3.2.1/REST/?_ga=2.54972013.718843537.1525972331-183410907.1506410127#usermanagement/1/session-validateToken
             * Response does not have a key active
             *if(isset($crowdSession->active) && !$crowdSession->active){
                if ($user){
                    User::deactivateUser($user);
                }
                $errorArr['error'] = 'Your account is suspended, contact Skynix administrator';
            }
            */
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
                Yii::getLogger()->log( "CROWD: " . $email . ": logged in", Logger::LEVEL_INFO);
                $obj = AccessKey::toCrowd($email, $password);

                if($obj && $this->validCrowdUser($obj)) {   // if element 'reason' exist, some authentication error there in crowd

                    Yii::getLogger()->log( "CROWD: " . $email . ": authenticated", Logger::LEVEL_INFO);
                    $accesKey = AccessKey::findOne(['email' => $obj->email]);
                    if ($accesKey) {
                        // create crowd session
                        Yii::getLogger()->log( "CROWD: " . $email . ": checking crowd session: " . $accesKey->token, Logger::LEVEL_INFO);
                        $session = AccessKey::checkCrowdSession($accesKey->token);
                        if ( $session['isSuccess'] === false) {

                            Yii::getLogger()->log( "CROWD: " . $email . ": crowd session invalid: " . $session['reason'], Logger::LEVEL_INFO);
                            $newSession = AccessKey::createCrowdSession($email, $password);
                            Yii::getLogger()->log( "CROWD: " . $email . ": created a new crowd session: " . $newSession->reason, Logger::LEVEL_INFO);
                            AccessKey::updateAll(['token' => $newSession->token, 'expiry_date' => AccessKey::getExpireForSession($newSession)],
                                ['email' => $email]);
                        } else {

                            Yii::getLogger()->log( "CROWD: " . $email . ": validated crowd session", Logger::LEVEL_INFO);
                            AccessKey::validateCrowdSession( $session['token'] );

                        }

                    } else {
                        // write to access_keys with existed user
                        AccessKey::createAccessKey($email, $password, $user->id, $obj);
                    }
                    AccessKey::putAvatarInAm($email);
                } else {

                    $errorArr['error'] = $this->getMessageFromCrowd($obj);
                    Yii::getLogger()->log( "CROWD: " . $email . ": authentication error: " .  $errorArr['error'], Logger::LEVEL_INFO);
                }
            }  //elseif(check for another auth type){}

        } else {

            $obj = AccessKey::toCrowd($email, $password);
            if($obj && $this->validCrowdUser($obj)) {     // if element 'reason' exist, some autentication error there in crowd
                    AccessKey::createUser($obj, $password);
                    AccessKey::putAvatarInAm($email);
            } else {
                $errorArr['error'] = $this->getMessageFromCrowd($obj);
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
        $toName = AccessKey::nameFromURL();
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
                        if(isset($_COOKIE[User::READ_COOKIE_NAME . $toName])) {

                            $session = AccessKey::checkCrowdSession($_COOKIE[User::READ_COOKIE_NAME . $toName]);
                            if( $session['isSuccess'] === false ){
                                $this->createCrowdSessionAndCookie($email, $password);
                            }
                        } else {

                            $this->createCrowdSessionAndCookie($email, $password);
                        }
                    AccessKey::putAvatarInAm($email);
                } else {
                    $errorArr['error'] = $this->getMessageFromCrowd($obj);
                }

            } elseif($user->auth_type == User::DATABASE_AUTH){
                $this->createCookie();
                AccessKey::putAvatarInAm($email);
            }       // another auth types

        } else {
            $obj = AccessKey::toCrowd($email, $password);
            if($obj && $this->validCrowdUser($obj)) {     // if element 'reason' exist, some autentication error there in crowd
                        AccessKey::createUser($obj, $password);
                        AccessKey::putAvatarInAm($email);
            } else {
                $errorArr['error'] = $this->getMessageFromCrowd($obj);
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
        } elseif(isset($obj->reason)) {
            return false;
        }
    }

    public function getMessageFromCrowd($obj)
    {
        // {"reason":"USER_NOT_FOUND","message":"User <email@skynix.co> does not exist"}
        return $obj->message . " in Crowd";
    }

    /**
     * @param $email
     * @param $password
     */
    private function createCrowdSessionAndCookie($email, $password)
    {
        $path = "/";
        $domain = AccessKey::getStringFromURL();
        $toName = AccessKey::nameFromURL();
        $newSession = AccessKey::createCrowdSession($email, $password);
        setcookie(User::CREATE_COOKIE_NAME . $toName, $newSession['token'], $newSession['expiryDate'], $path, $domain);

        // delete db authorization cookie
        setcookie(User::COOKIE_DATABASE . $toName, 'authorized_through_database',time()-3600*60, $path, $domain);

    }

    /**
     *
     */
    public function createCookie()
    {
        $path = "/";
        $domain = AccessKey::getStringFromURL();
        $toName = AccessKey::nameFromURL();

        setcookie(User::COOKIE_DATABASE . $toName, 'authorized_through_database',time()+(60*30), $path, $domain);
        //delete crowd cookie
        setcookie(User::CREATE_COOKIE_NAME . $toName,"",time()-3600*60, $path, $domain);

    }

    /**
     * @param $session
     */
    public function prolongCrowdCookie($session)
    {
        $path = "/";
        $domain = AccessKey::getStringFromURL();
        $toName = AccessKey::nameFromURL();

        // get difference beetwen create and expiry date of the crowd session instead of hardcode 30 min
        $created = substr($session['createdDate'], 0, 10);
        $expiry = substr($session['expiryDate'], 0, 10);
        $dateDiff = $expiry - $created;

        // set crowd.token_key cookie with value of current crowd token and expiry extended by expiry crowd date difference(30 min)
        setcookie(User::CREATE_COOKIE_NAME . $toName, $_COOKIE[User::READ_COOKIE_NAME . $toName],time() + $dateDiff, $path, $domain);

    }
}
