<?php
/**
 * Created by Skynix Team
 * Date: 20.04.17
 * Time: 16:48
 */

namespace viewModel;

use Yii;
use app\models\User;
use app\models\Contract;
use app\models\Invoice;
use yii\helpers\Url;
use app\modules\api\components\Api\Processor;

class ContractView extends ViewModelAbstract
{
    public function define()
    {
        $id = Yii::$app->request->get("id");
        $listContract = [];
        if ($contract = Contract::findOne($id)) {
            $initiator = User::findOne($contract->created_by);
            $customer = User::findOne($contract->customer_id);
            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) || (User::hasPermission([User::ROLE_SALES]) && ($this->model->created_by == Yii::$app->user->id))) {
                $listContract = [
                    'contract_id' => $contract->contract_id,
                    'customer' => [
                        'id' => $customer->id,
                        'name' => $customer->first_name . ' ' . $customer->last_name
                    ],
                    'act_number' => $contract->act_number,
                    'start_date' => date("d/m/Y", strtotime($contract->start_date)),
                    'end_date' => date("d/m/Y", strtotime($contract->end_date)),
                    'act_date' => date("d/m/Y", strtotime($contract->act_date)),
                    'total' => '$' . number_format($contract->total, 2),
                    'download_contract_url' => Url::home(true) . 'cp/contract/downloadcontract?id=' . $contract->id,
                    'download_act_url' => Url::home(true) . 'cp/contract/downloadactofwork?id=' . $contract->id,
                ];

                $invoice = Invoice::find()->where(['contract_number' => $contract->id])->all();
                if ($invoice) {
                    $listContract['download_invoice_url'] = Url::home(true) . 'cp/invoice/download?id=' . $invoice->id;
                } else {
                    $listContract['download_invoice_url'] = null;
                }

                $listContract['created_by'] = [
                    'id' => $initiator->id,
                    'name' => $initiator->first_name . ' ' . $initiator->last_name
                ];
            } else {
                return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
            }
            $this->setData($listContract);
        }
    }
}
