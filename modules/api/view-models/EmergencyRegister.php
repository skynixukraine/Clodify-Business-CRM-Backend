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

                    $message = 'Hey ' . $user->first_name . '! Emergency';

                    //Getting Jira Payload
                    if (  ( $json = Yii::$app->request->getRawBody() ) &&
                    ( $data = json_decode($json, true)) &&
                    isset($data['issue']['key'])) {


                        $message .= " " . data['issue']['key'];

                    }
                    Yii::getLogger()->log($json, Logger::LEVEL_INFO);
                    $emergency = new Emergency();
                    $emergency->user_id         = $userId;
                    $emergency->date_registered = time();
                    $emergency->summary         = $message;
                    $emergency->save();

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