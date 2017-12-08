<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 09.11.17
 * Time: 12:06
 */

namespace viewModel;

use app\models\Transaction;
use app\models\User;
use app\models\Operation;
use app\modules\api\components\Api\Processor;
use Yii;
use yii\db\Exception;

/**
 * Class OperationCreate
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-55
 * @author  Igor (Skynix)
 */
class OperationCreate extends ViewModelAbstract
{
    private $operationId;

    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                // get POST data
                $bussiness_id           = $this->postData['bussiness_id'];
                $name                   = $this->postData['name'];
                $operation_type_id      = $this->postData['operation_type_id'];
                $transaction_name       = $this->postData['transaction_name'];
                $amount                 = $this->postData['amount'];
                $currency               = $this->postData['currency'];
                $debit_reference_id     = $this->postData['debit_reference_id'];
                $credit_reference_id    = $this->postData['credit_reference_id'];
                $debit_counterparty_id  = $this->postData['debit_counterparty_id'];
                $credit_counterparty_id = $this->postData['credit_counterparty_id'];

                // create operation
                $operation = new Operation();
                $operation->business_id       = $bussiness_id;
                $operation->name              = $name;
                $operation->status            = Operation::DONE;
                $operation->date_created      = time();
                $operation->operation_type_id = $operation_type_id;
                $operation->setScenario(Operation::SCENARIO_OPERATION_CREATE);
                if ($operation->validate() && $operation->save()) {
                    $this->operationId = $operation->id;
                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Your operation failed'));
                }

                // create two transactions for DEBIT and CREDIT
                $transaction1 = new Transaction();
                $transaction1->type                  = Transaction::DEBIT;
                $transaction1->name                  = $transaction_name;
                $transaction1->date                  = time();
                $transaction1->amount                = $amount;
                $transaction1->currency              = $currency;
                $transaction1->reference_book_id     = $debit_reference_id;
                $transaction1->counterparty_id       = $debit_counterparty_id;
                $transaction1->operation_id          = $this->operationId;
                $transaction1->operation_business_id = $bussiness_id;

                $transaction2 = new Transaction();
                $transaction2->type                  = Transaction::CREDIT;
                $transaction2->name                  = $transaction_name;
                $transaction2->date                  = time();
                $transaction2->amount                = $amount;
                $transaction2->currency              = $currency;
                $transaction2->reference_book_id     = $credit_reference_id;
                $transaction2->counterparty_id       = $credit_counterparty_id;
                $transaction2->operation_id          = $this->operationId;
                $transaction2->operation_business_id = $bussiness_id;
                $transaction2->setScenario(Transaction::SCENARIO_TRANSACTION_CREATE);
                $transaction1->setScenario(Transaction::SCENARIO_TRANSACTION_CREATE);
                if ($transaction1->save() && $transaction2->save()) {
                    $transaction->commit();
                    $this->setData([
                        'operation' => $this->operationId
                    ]);
                } else {
                    $transaction->rollBack();
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Your transactions failed'));
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }

}