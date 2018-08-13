<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 13:28
 */

namespace viewModel;

use Yii;
use app\models\PaymentMethod;
use app\models\User;
use app\modules\api\components\Api\Processor;

class PaymentMethodSetDefault extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {

            $paymentMethodId = Yii::$app->request->getQueryParam('payment_method_id');
            $businessId = Yii::$app->request->getQueryParam('business_id');


            $pm = PaymentMethod::find()->where('id = :id', [':id' => $paymentMethodId])->one();

            if(is_null($pm) || empty($pm)) {
                return $this->addError(Processor::ERROR_PARAM, 'Cannot find Payment method');
            }


            PaymentMethod::updateAll(
                ['is_default' => 1],
                'business_id = :business_id AND id = :payment_method_id',
                [
                    ':business_id' => $businessId,
                    ':payment_method_id' => $paymentMethodId
                ]
            );

            $data = ['id'=> $paymentMethodId];
            $this->setData($data);

                PaymentMethod::updateAll(
                    ['is_default' => 0],
                    'business_id = :business_id AND id != :payment_method_id',
                    [
                        ':business_id' => $businessId,
                        ':payment_method_id' => $paymentMethodId
                    ]
                );


        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}