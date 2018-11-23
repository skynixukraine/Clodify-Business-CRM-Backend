<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/8/18
 * Time: 8:40 AM
 */

namespace app\commands;

use app\models\CoreClient;
use app\models\CoreClientOrder;
use app\models\Setting;
use Yii;
use yii\log\Logger;
use app\models\CoreClientKey;

class CoreController extends DefaultController
{
    /**
     *
     */
    public function actionUpdateClientAccessKeys()
    {
        try {
            Yii::getLogger()->log('actionUpdateClientAccessKeys running', Logger::LEVEL_INFO);

            $clientKeys = new \app\models\CoreClientKey();
            $clientKeys->client_id      = Setting::getClientId();
            $clientKeys->valid_until    = date('Y-m-d', strtotime('now +1day'));
            $clientKeys->access_key     = Yii::$app->security->generateRandomString( 45 );
            $clientKeys->save();

            if ( ( $setting = Setting::find()
                ->where(['key' => Setting::CLIENT_ACCESS_KEY])
                ->one() ) ) {

                $setting->value = $clientKeys->access_key;
                $setting->save(false, ['value']);
            }

        } catch (\Exception $e ) {

            Yii::getLogger()->log('actionUpdateClientAccessKeys error ' .
                $e->getMessage() .
                $e->getTraceAsString(),
                Logger::LEVEL_ERROR);
        }

    }

    public function actionProcessOrders()
    {
        Yii::getLogger()->log('actionProcessOrders running', Logger::LEVEL_INFO);

        try {
           if ( ($orders = CoreClientOrder::find()->where(['status' => CoreClientOrder::STATUS_ONREVIEW])->all())) {

               /** @var  $order CoreClientOrder */
               foreach ( $orders as $order ) {

                    $order->checkGateway();

               }

           }

        } catch (\Exception $e ) {

            Yii::getLogger()->log('actionProcessOrders error ' .
                $e->getMessage() .
                $e->getTraceAsString(),
                Logger::LEVEL_ERROR);
        }
    }

    /**
     *  Informs users by email when the subscription ends in 3 days
     */
    public function actionInformClientsSubscriptionEnding (){
        Yii::getLogger()->log('actionInformClientsSubscriptionEnding running', Logger::LEVEL_INFO);

        try {
            if(($clients = CoreClient::find()->where(['prepaid_for'=>date('Y-m-d', strtotime('now +3days'))])->all())) {
                foreach( $clients as $client) {
                    $mail = Yii::$app->mailer->compose('subscriptionExpires')
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($client->email)
                        ->setSubject('The subscription expires in 3 days');

                    if (!$mail->send()) {
                        throw new Exception('an email haven\'t been sent');
                    }
                }
            }

        } catch(\Exception $e) {
            Yii::getLogger()->log('actionInformClientsSubscriptionEnding error' .
            $e->getMessage() .
            $e->getTraceAsString(),
            Logger::LEVEL_ERROR);
        }
    }


    /**
     *  Informs users by email when the subscription have expired
     */
    public function actionInformClientsSubscriptionEnded (){
        Yii::getLogger()->log('actionInformClientsSubscriptionEnded running', Logger::LEVEL_INFO);

        try {
            if(($clients = CoreClient::find()->where(['prepaid_for'=>date('Y-m-d', strtotime('now'))])->all())) {
                foreach( $clients as $client) {
                    $mail = Yii::$app->mailer->compose('subscriptionExpired')
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($client->email)
                        ->setSubject('The subscription have expired');

                    if (!$mail->send()) {
                        throw new Exception('an email haven\'t been sent');
                    }
                }
            }

        } catch(\Exception $e) {
            Yii::getLogger()->log('actionInformClientsSubscriptionEnded error' .
                $e->getMessage() .
                $e->getTraceAsString(),
                Logger::LEVEL_ERROR);
        }
    }



}