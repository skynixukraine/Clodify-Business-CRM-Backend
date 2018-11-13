<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/13/18
 * Time: 10:03 AM
 */
namespace viewModel;

use app\models\CoreClient;
use app\modules\api\models\ApiAccessToken;
use Yii;
use app\models\User;
use app\modules\api\models\ApiLoginForm;
use app\modules\api\components\Api\Processor;
use yii\log\Logger;


class PaymentCallback extends ViewModelAbstract
{
    /**
     * @var CoreClient
     */
    protected $model;

    public function define()
    {
        Yii::getLogger()->log("PaymentCallback", Logger::LEVEL_INFO);
        $domain = null;
        if ( ( $payment = Yii::$app->request->post('payment') ) &&
            ( $signature = Yii::$app->request->post('signature') ) ) {

            Yii::getLogger()->log($payment, Logger::LEVEL_INFO);

            if ( ($sign = sha1 (md5($payment.Yii::$app->params['merchantPassword']))) === $signature ) {

                $orderId = null;
                $state   = null;
                foreach (explode('&', $payment) as $chunk) {
                    $param = explode("=", $chunk);

                    if ($param && $param[0] === "order") {

                        $orderId = $param[1];

                    } else if ($param && $param[0] === "state") {

                        $state = $param[1];

                    }
                }
                if ( $orderId > 0 ) {
                    /** @var CoreClientOrder */
                    if ( ($clientOrder = CoreClientOrder::findOne($orderId))) {

                        if ( $state === 1 || $state === "test") {

                            $clientOrder->status = CoreClientOrder::STATUS_PAID;

                        } else {

                            $clientOrder->status = CoreClientOrder::STATUS_CANCELED;
                        }
                        $clientOrder->payment = $payment;
                        $clientOrder->save(false, ['status', 'payment']);

                        /** @var $client CoreClient */
                        if ( ($client = CoreClient::findOne($clientOrder->client_id))) {

                            $domain = $client->getUnConvertedDomain();

                        }

                    } else {

                        Yii::getLogger()->log("Merchant Order is not found !!!", Logger::LEVEL_WARNING);

                    }

                } else {

                    Yii::getLogger()->log("Merchant Order ID is not present!!!", Logger::LEVEL_WARNING);

                }

            } else {

                Yii::getLogger()->log("Merchant signature is wrong!!!", Logger::LEVEL_WARNING);
                Yii::getLogger()->log($signature, Logger::LEVEL_WARNING);
                Yii::getLogger()->log($sign, Logger::LEVEL_WARNING);

            }

        } else {

            Yii::getLogger()->log("Merchant data is blank!!!! " . Yii::$app->request->getRawBody(), Logger::LEVEL_WARNING);

        }

    }
}