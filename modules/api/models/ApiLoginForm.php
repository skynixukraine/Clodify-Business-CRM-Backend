<?php

namespace app\modules\api\models;

use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use yii\base\Model;
use app\modules\api\models\ApiAccessToken;
use app\models\LoginForm;
use yii\helpers\Json;
use yii\log\Logger;

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
        $this->flushUser();
        $user = $this->getUser();
        $user->date_login = date('Y-m-d H:i:s');

        if( !($accessToken = ApiAccessToken::find()->where(['user_id' => $user->id])->one()) ||
            ( ( strtotime( $accessToken->exp_date ) < strtotime("now -" . ApiAccessToken::EXPIRATION_PERIOD ) ) ) ) {

            $accessToken = ApiAccessToken::generateNewToken( $user );

        }
        if ( $user->auth_type === User::CROWD_AUTH ) {

            if ( $accessToken->crowd_token &&
                $accessToken->crowd_exp_date > time() &&
                ($response = Yii::$app->crowdComponent->validateCrowdSession( $accessToken->crowd_token )) &&
                $response['success'] === true
            ) {

                $accessToken->crowd_exp_date = $response['expiryDate'];


            } elseif ( ($response = Yii::$app->crowdComponent->createCrowdSession( $this->email, $this->password )) &&
                $response['success'] === true ) {

                $accessToken->crowd_exp_date    = $response['expiryDate'];
                $accessToken->crowd_token       = $response['token'];

                //Yii::$app->crowdComponent->putAvatarInAm( $this->email );

            } else {

                Yii::getLogger()->log( "CROWD: can not login " . (!empty($response['reason']) ?$response['reason'] :"-" ), Logger::LEVEL_WARNING);
                return false;

            }

        }
        $accessToken->save();
        $user->save(false, ['date_login']);
        return $accessToken;

    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ( $user &&
                ($user->auth_type === User::DATABASE_AUTH || $user->auth_type === User::CROWD_AUTH) &&
                $user->is_system === 0 ) {

                if ( $user->auth_type === User::DATABASE_AUTH ) {

                    if ( !$user->validatePassword($this->password) ) {

                        $this->addError($attribute, 'Incorrect email or password.');

                    }
                    if ( $user->is_active !== 1 ) {

                        $this->addError($attribute, 'Your account is blocked.');

                    }

                } else if ( $user->auth_type === User::CROWD_AUTH ) {

                    //Request CROWD to check username/password
                    if ( ( $response = Yii::$app->crowdComponent->authenticateToCrowd( $this->email, $this->password) ) &&
                        $response['success'] === false ) {

                        $this->addError($attribute, "Faild request to crowd. Try again please.");
                        Yii::getLogger()->log( "Faild request to crowd. Try again please." . implode(', ', $response['errors']), Logger::LEVEL_WARNING);

                    }

                }

            } elseif ( $user && $user->is_system !== 0 ) {

                $this->addError($attribute, Yii::t('app', 'Username or password is wrong'));
                Yii::getLogger()->log( "Tried to login as system user" . $user->email, Logger::LEVEL_WARNING);

            } else {

                if ( ( $response = Yii::$app->crowdComponent->authenticateToCrowd( $this->email, $this->password) ) &&
                    $response['success'] === true &&
                    $response['user']['active'] === true) {

                    //User does not exist in the database, but exists in crowd, creating it
                    $user = User::createASingleDevUser($response['user'], $this->password);

                } else {

                    $this->addError($attribute, Yii::t('app', 'Username or password is wrong'));
                    Yii::getLogger()->log( "CROWD: does not exist " . var_export($response, 1), Logger::LEVEL_INFO);


                }

            }
        }
    }

}