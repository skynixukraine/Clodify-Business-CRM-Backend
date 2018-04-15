<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 4/14/18
 * Time: 10:57 AM
 */

namespace viewModel;
use app\models\Emergency;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;
use yii\log\Logger;

class EmergencyRegister  extends ViewModelAbstract
{
    const HEADER_SECURITY_TOKEN         = 'SkynixEmergency';
    const HEADER_SECURITY_TOKEN_VALUE   = 'JhzK@lDJ02H5GHmN30139kHP';


    /**
     * @see https://www.twilio.com/docs/notify/quickstart/sms#set-up-notify-service-instance
     * @return $this
     */
    public function define()
    {

        if ( ($token = Yii::$app->request->headers->get(self::HEADER_SECURITY_TOKEN)) &&
            ($token == self::HEADER_SECURITY_TOKEN_VALUE)) {

            /** @var $user User */
            if ( ($userId = Yii::$app->request->get("user_id") ) &&
                ( $user = User::findOne(['id' => $userId]))) {

                if ( !empty($user->phone) && strlen($user->phone) == 13 ) {

                    $client = new Client(
                        Yii::$app->params['twillio']['accountSid'],
                        Yii::$app->params['twillio']['token']);

                    $serviceSid = Yii::$app->params['twillio']['serviceSid'];

                    //Getting Jira Payload
                    if (  ( $json = Yii::$app->request->getRawBody() ) &&
                    ( $data = json_decode($json, true))) {



                    }
                    Yii::getLogger()->log($json, Logger::LEVEL_INFO);
                    $message = 'Hey ' . $user->first_name . '! Emergency happened!';
                    $emergency = new Emergency();
                    $emergency->user_id         = $userId;
                    $emergency->date_registered = time();
                    $emergency->summary         = $message;
                    $emergency->save();
                    // Use the client to do fun stuff like send text messages!
                    $client
                        ->notify->services($serviceSid)
                        ->notifications->create([
                            "toBinding" => '{"binding_type":"sms", "address": "' .  $user->phone . '"}',
                            'body'      => $message
                    ]);

                } else {

                    return $this->addError(Processor::ERROR_PARAM,
                        Yii::t('app', '%s does not have a phone number. Correct phone format is +380XXXXXXXXX', [$user->first_name]));

                }

            } else {

                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Requested user does not exist'));
            }

        } else {
            return $this->addError(Processor::STATUS_CODE_UNAUTHORIZED, Yii::t('app', 'You have no permission for this action'));
        }

    }

}