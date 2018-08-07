<?php
/**
 * Created by Skynix Team
 * Date: 18.04.17
 * Time: 10:48
 */

namespace viewModel;

use app\models\PaymentMethod;
use Yii;


class PaymentMethodFetch extends ViewModelAbstract
{

    public function define()
    {

        $id = Yii::$app->request->getQueryParam('id');

        $paymentMethodData = PaymentMethod::find()->where(['id' => $id])->one();

        $data = [];
        if ($paymentMethodData) {
            $data[] = $paymentMethodData->toArray([
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

        } else {
            $this->addError('data', 'Payment method not found');
        }

        $this->setData($data);

    }

}