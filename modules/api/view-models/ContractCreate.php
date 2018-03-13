<?php
/**
 * Created by Skynix Team
 * Date: 20.04.17
 * Time: 14:09
 */

namespace viewModel;

use Yii;
use app\components\DateUtil;
use app\models\User;
use app\modules\api\components\Api\Processor;

class ContractCreate extends ViewModelAbstract
{
    /** @deprecated */
    public function define()
    {
        trigger_error('Method ' . Yii::$app->controller->action->id . ' is deprecated', E_USER_DEPRECATED);

        $this->model->created_by = Yii::$app->user->id;
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])){
            if ($this->validate()) {
                $this->model->start_date = DateUtil::convertData($this->model->start_date);
                $this->model->end_date = DateUtil::convertData($this->model->end_date);
                $this->model->act_date = DateUtil::convertData($this->model->act_date);

                $this->model->save();
                $this->setData([
                    'contract_id' => $this->model->id
                ]);
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }

}