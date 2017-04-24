<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 11:23
 */

namespace viewModel;

use Yii;
use app\models\Contract;
use app\models\Invoice;
use app\models\User;

class ContractDelete extends ViewModelAbstract
{
    public function define()
    {
        $contractId = Yii::$app->request->getQueryParam("contract_id");
        $contract = Contract::findOne($contractId);

        if (User::hasPermission([User::ROLE_ADMIN])
            || (User::hasPermission([User::ROLE_FIN])
                && $contract->customer_id == Yii::$app->user->id)) {

            if ($contract) {
                $invoices = Invoice::find()
                    ->where(['contract_id' => $contract->id])
                    ->all();
                foreach ($invoices as $invoice) {
                    if ($invoice->is_delete == 0) {
                        return $this->addError('error', 'Contract can not be deleted, due to existing invoice.');
                    }
                }
                $contract->delete();
                Invoice::deleteAll(['contract_id' => $contract->id]);
            }

        } else {
            return $this->addError('error', 'Not authorize to do this action.');
        }
    }
}