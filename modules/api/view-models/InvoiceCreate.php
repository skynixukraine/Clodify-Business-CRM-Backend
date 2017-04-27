<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 13:28
 */

namespace viewModel;

use Yii;
use app\models\Contract;

class InvoiceCreate extends ViewModelAbstract
{
    public function define()
    {
        $id = Yii::$app->request->getQueryParam("id");

        if ($id && ( $contract = Contract::findOne($id))) {
            $this->model->created_by = Yii::$app->user->id;
            $this->model->contract_id = $contract->id;
            $this->model->contract_number = $contract->contract_id;
            $this->model->act_of_work = $contract->act_number;
            $this->model->total = $contract->total;
            $this->model->user_id = $contract->customer_id;
            $this->model->date_start = date('d/m/Y', strtotime($contract->start_date));
            $this->model->date_end = date('d/m/Y', strtotime($contract->end_date));
        }

        /** Invoice - total logic */
        if ($this->model->total != null && $this->model->discount == null) {
            $this->model->discount = 0;
            $this->model->subtotal = $this->model->total;
        }
        if ($this->model->total !=null && $this->model->discount != null) {
            $this->model->subtotal = $this->model->total;
            $this->model->total = ($this->model->subtotal - $this->model->discount);
        }

        if ($this->model->total_hours) {
            $this->model->total_hours = Yii::$app->Helper->timeLength($this->model->total_hours);
        }

        $this->model->date_created = date('Y-m-d');

        if ($this->validate() && $this->model->save()) {
            $this->setData([
                'invoice_id' => $this->model->id
            ]);
        }
    }
}