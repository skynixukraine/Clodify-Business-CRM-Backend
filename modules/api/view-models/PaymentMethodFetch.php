<?php
/**
 * Created by Skynix Team
 * Date: 18.04.17
 * Time: 10:48
 */

namespace viewModel;

use Yii;
use app\models\PaymentMethod;
use app\models\User;
use app\modules\api\components\Api\Processor;


class PaymentMethodFetch extends ViewModelAbstract
{

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN])) {
            $businessId = Yii::$app->request->getQueryParam('id');

            $paymentMethodData = PaymentMethod::find()->where(['business_id' => $businessId])->all();

            $data = [];
            if ($paymentMethodData) {
                foreach ($paymentMethodData as $paymentMethodDatum) {
                    $data[] = $paymentMethodDatum->toArray([
                        'id',
                        'name',
                        'name_alt',
                        'address',
                        'address_alt',
                        'represented_by',
                        'represented_by_alt',
                        'bank_information',
                        'bank_information_alt',
                        'is_default'
                    ]);
                }
            } else {
                $this->addError('data', 'Payment method not found');
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }

        $this->setData($data);

    }

}