<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/27/18
 * Time: 12:27 PM
 */

namespace viewModel;

use app\models\User;
use app\modules\api\components\Api\Processor;
use app\modules\api\models\ApiAccessToken;
use Yii;

class SSOCheck extends ViewModelAbstract
{
    public function define()
    {

        if ( isset($this->postData['token']) &&
            !empty($this->postData['token']) &&
            ($response = Yii::$app->crowdComponent->validateCrowdSession( $this->postData['token'] )) ) {

            if ( $response['success'] === true ) {

                /** @var $accessToken ApiAccessToken */
                if ( !(($accessToken = ApiAccessToken::find()->where(['crowd_token' => $response['token']])->one()) &&
                    $accessToken->crowd_exp_date > time()) ) {

                    if ( $accessToken ) {

                        $user = User::findOne( $accessToken->user_id );

                    } else {

                        if ( !($user = User::find()->where(['email' => $response['user']['email']])->one() ) ) {

                            $user = User::createASingleDevUser($response['user'], Yii::$app->security->generateRandomString( 30));

                        }

                    }
                    $accessToken = ApiAccessToken::generateNewToken( $user );

                }
                $accessToken->crowd_exp_date = $response['expiryDate'];
                $accessToken->exp_date       = date("Y-m-d H:i:s");
                $accessToken->crowd_token    = $response['token'];
                $accessToken->save();
                $this->setData([
                    'access_token'  => $accessToken->access_token,
                    'user_id'       => $accessToken->user_id,
                    'role'          => User::findOne( $accessToken->user_id )->role,
                    'crowd_token'   => $accessToken->crowd_token
                ]);


            } else {

                $this->addError(Processor::CROWD_ERROR_PARAM, $response['reason']);

            }

        }

    }

}