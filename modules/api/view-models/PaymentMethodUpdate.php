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

class PaymentMethodUpdate extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {

            $paymentMethodId = Yii::$app->request->getQueryParam('payment_method_id');
            $businessId = Yii::$app->request->getQueryParam('business_id');

            $requiredFields = [
                'name',
                'address',
                'represented_by',
                'bank_information',
                'is_default',
                'business_id'
            ];

            foreach($requiredFields as $elem) {
                if(!array_key_exists($elem, $this->postData))
                    return $this->addError(Processor::ERROR_PARAM, 'missing required field ' . $elem);
            }

            if ($this->validate()) {
                PaymentMethod::updateAll(
                    $this->postData,
                    'business_id = :business_id AND id = :payment_method_id',
                    [
                        ':business_id' => $businessId,
                        ':payment_method_id' => $paymentMethodId
                    ]
                );

                $data = $this->postData;
                $data = ['id'=> 2] + $data;

                $this->setData($data);
                if($this->model->is_default == 1) {
                    PaymentMethod::updateAll(
                        ['is_default' => 0],
                        'business_id = :business_id AND id != :payment_method_id',
                        [
                            ':business_id' => $businessId,
                            ':payment_method_id' => $paymentMethodId
                        ]
                    );
                }
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}