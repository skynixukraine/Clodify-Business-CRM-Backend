<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 13:28
 */

namespace viewModel;

use Yii;
use app\models\Contract;
use app\models\User;
use app\modules\api\components\Api\Processor;

class InvoiceCreate extends ViewModelAbstract
{
    public function define()
    {
//        $id = Yii::$app->request->getQueryParam("id");
//        if ($id && ($contract = Contract::findOne($id))) {
//            //SALES can view, invoice & edit only own contracts
//            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) || (User::hasPermission([User::ROLE_SALES]) && ($contract->created_by == Yii::$app->user->id))) {
//                $this->model->created_by = Yii::$app->user->id;
//                $this->model->contract_id = $contract->id;
//                $this->model->contract_number = $contract->contract_id;
//                $this->model->act_of_work = $contract->act_number;
//                $this->model->total = $contract->total;
//                $this->model->user_id = $contract->customer_id;
//                $this->model->date_start = date('d/m/Y', strtotime($contract->start_date));
//                $this->model->date_end = date('d/m/Y', strtotime($contract->end_date));
//            } else {
//                return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
//            }
//        }
//
//        /** Invoice - total logic */
//        if ($this->model->total != null && $this->model->discount == null) {
//            $this->model->discount = 0;
//            $this->model->subtotal = $this->model->total;
//        }
//        if ($this->model->total != null && $this->model->discount != null) {
//            $this->model->subtotal = $this->model->total;
//            $this->model->total = ($this->model->subtotal - $this->model->discount);
//        }
//
//        if ($this->model->total_hours) {
//            $this->model->total_hours = Yii::$app->Helper->timeLength($this->model->total_hours);
//        }

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $this->model->created_by = Yii::$app->user->id;
            $this->model->date_start = date('d/m/Y', strtotime($this->model->date_start));
            $this->model->date_end = date('d/m/Y', strtotime($this->model->date_end));
            $this->model->date_created = date('Y-m-d');

            if ($this->validate() && $this->model->save()) {
                $this->setData([
                    'invoice_id' => $this->model->id
                ]);
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}