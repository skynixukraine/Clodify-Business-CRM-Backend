<?php
/**
 * Created by Skynix Team
 * Date: 20.04.17
 * Time: 18:19
 */

namespace viewModel;

use Yii;
use app\models\Contract;
use app\models\Invoice;
use app\components\DateUtil;
use app\models\User;
use app\modules\api\components\Api\Processor;

class ContractEdit extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])){
            if ($id = Yii::$app->request->get('contract_id')) {
                if ($this->validate() && ($this->model = Contract::findOne($id))) {
                    //SALES can view, invoice & edit only own contracts
                    if (User::hasPermission([User::ROLE_SALES]) && ($this->model->created_by == Yii::$app->user->id)) {
                        $this->model->start_date = DateUtil::convertData($this->model->start_date);
                        $this->model->end_date = DateUtil::convertData($this->model->end_date);
                        $this->model->act_date = DateUtil::convertData($this->model->act_date);
                        $this->model->setAttributes($this->postData);
                        $this->model->save();

                        if (($invoice = Invoice::findOne(['contract_id' => $this->model->id, 'is_delete' => 0]))) {

                            $invoice->contract_id = $this->model->id;
                            $invoice->contract_number = $this->model->contract_id;
                            $invoice->act_of_work = $this->model->act_number;
                            $invoice->date_start = $this->model->start_date;
                            $invoice->date_end = $this->model->end_date;
                            $invoice->total = $this->model->total;
                            $invoice->user_id = $this->model->customer_id;
                            /** Invoice - total logic */
                            if ($invoice->total != null && $invoice->discount == null) {

                                $invoice->discount = 0;
                                $invoice->subtotal = $invoice->total;

                            }
                            if ($invoice->total != null && $invoice->discount != null) {
                                $invoice->subtotal = $invoice->total;
                                $invoice->total = ($invoice->subtotal - $invoice->discount);

                            }
                            if ($invoice->validate()) {
                                $invoice->save();
                            }
                        }
                    }else {
                        return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
                    }
                }
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }

}