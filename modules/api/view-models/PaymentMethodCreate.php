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

class PaymentMethodCreate extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {
            $this->model->load(Yii::$app->request->post());

            if ($this->validate() && $this->model->save()) {
                $this->setData([
                    'payment_method_id' => $this->model->id
                ]);
                if($this->model->is_default == 1) {
                    PaymentMethod::updateAll(
                        ['is_default' => 0],
                        'business_id = :business_id AND id != :id',
                        [
                            ':business_id' => $this->model->business_id,
                            ':id' => $this->model->id
                        ]
                    );
                }
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}