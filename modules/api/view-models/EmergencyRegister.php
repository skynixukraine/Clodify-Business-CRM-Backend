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


    public function define()
    {

        if ( ($token = Yii::$app->request->headers->get(self::HEADER_SECURITY_TOKEN)) &&
            ($token == self::HEADER_SECURITY_TOKEN_VALUE)) {

            /** @var $user User */
            if ( ($userId = Yii::$app->request->get("user_id") ) &&
                ( $user = User::findOne(['id' => $userId]))) {

                if ( !empty($user->phone) && strlen($user->phone) == 13 ) {

                    $client = new Client(
                        Yii::$app->params['twillio']['sid'],
                        Yii::$app->params['twillio']['token']);

                    //Getting Jira Payload
                    if (  ( $json = Yii::$app->request->getRawBody() ) &&
                    ( $data = json_decode($json, true))) {

                        Yii::getLogger()->log($json, Logger::LEVEL_INFO);

                    }
                    $message = 'Hey ' . $user->first_name . '! Emergency happened!';
                    $emergency = new Emergency();
                    $emergency->user_id         = $userId;
                    $emergency->date_registered = time();
                    $emergency->summary         = $message;
                    $emergency->save();
                    // Use the client to do fun stuff like send text messages!
                    $client->messages->create(
                    // the number you'd like to send the message to
                        $user->phone,
                        array(
                            // A Twilio phone number you purchased at twilio.com/console
                            'from' => Yii::$app->params['twillio']['from'],
                            // the body of the text message you'd like to send
                            'body' => $message
                        )
                    );

                } else {

                    return $this->addError(Processor::ERROR_PARAM,
                        Yii::t('yii', '%s does not have a phone number. Correct phone format is +380XXXXXXXXX', [$user->first_name]));

                }

            } else {

                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Requested user does not exist'));
            }

        } else {
            return $this->addError(Processor::STATUS_CODE_UNAUTHORIZED, Yii::t('yii', 'You have no permission for this action'));
        }

    }

}