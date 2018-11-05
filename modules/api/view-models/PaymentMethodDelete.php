<?php
/**
 * Created by Skynix Team
 * Date: 18.04.17
 * Time: 10:48
 */

namespace viewModel;

use Yii;
use app\models\PaymentMethod;
use app\models\Invoice;
use app\models\User;
use app\modules\api\components\Api\Processor;


class PaymentMethodDelete extends ViewModelAbstract
{

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN])) {

            $businessId = Yii::$app->request->getQueryParam('business_id');
            $paymentMethodId = Yii::$app->request->getQueryParam('payment_method_id');
            $paymentMethod = PaymentMethod::findOne(['business_id' => $businessId, 'id' => $paymentMethodId]);


            if(is_null($paymentMethod)) {
                return $this->addError(Processor::ERROR_PARAM, 'payment method isn\'t found');
            }

            if($paymentMethod->is_default == 1) {
                return $this->addError(Processor::ERROR_PARAM, 'Cannot delete default method');
            }

            $invoices = Invoice::findAll(['payment_method_id' => $paymentMethodId]);


            if(count($invoices) > 0) {
                return $this->addError(Processor::ERROR_PARAM, 'Cannot delete payment method, method attached to invoices');
            }

            $paymentMethod->delete();


        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }



    }

}