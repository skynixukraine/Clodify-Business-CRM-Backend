<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 09.11.17
 * Time: 12:06
 */

namespace viewModel;

use app\models\FixedAsset;
use app\models\FixedAssetOperation;
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
                $businessId           = $this->postData['business_id'];
                $name                 = $this->postData['name'];
                $operationTypeId      = $this->postData['operation_type_id'];
                $transactionName      = $this->postData['transaction_name'];
                $amount               = $this->postData['amount'];
                $currency             = $this->postData['currency'];
                $debitReferenceId     = $this->postData['debit_reference_id'];
                $creditReferenceId    = $this->postData['credit_reference_id'];
                $debitCounterpartyId  = $this->postData['debit_counterparty_id'];
                $creditCounterpartyId = $this->postData['credit_counterparty_id'];

                // create operation
                $operation = new Operation();
                $operation->business_id       = $businessId;
                $operation->name              = $name;
                $operation->status            = Operation::DONE;
                $operation->date_created      = time();
                $operation->operation_type_id = $operationTypeId;
                $operation->setScenario(Operation::SCENARIO_OPERATION_CREATE);
                if ($operation->validate() && $operation->save()) {
                    $this->operationId = $operation->id;
                    // create new fixed_asset if it exist in POST
                    if (isset($this->postData['fixed_asset'])) {
                        $fixedAsset = new FixedAsset();
                        $fixedAsset->name                = $this->postData['fixed_asset']['name'];
                        $fixedAsset->cost                = $this->postData['fixed_asset']['cost'];
                        $fixedAsset->inventory_number    = $this->postData['fixed_asset']['inventory_number'];
                        $fixedAsset->amortization_method = $this->postData['fixed_asset']['amortization_method'];
                        $fixedAsset->date_of_purchase    = $this->postData['fixed_asset']['date_of_purchase'];
                        if ($fixedAsset->validate() && $fixedAsset->save()) {
                            // create new fixed_assets_operation
                            $fixedAssetsOperation = new FixedAssetOperation();
                            $fixedAssetsOperation->fixed_asset_id        = $fixedAsset->id;
                            $fixedAssetsOperation->operation_id          = $this->operationId;
                            $fixedAssetsOperation->operation_business_id = $operation->business_id;
                            if ($fixedAssetsOperation->validate()) {
                                $fixedAssetsOperation->save();
                            } else {
                                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Creating fixed_assets_operation failed'));
                            }
                        } else {
                            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Creating fixed_asset failed'));
                        }
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Your operation failed'));
                }

                // create two transactions for DEBIT and CREDIT
                $transaction1 = new Transaction();
                $transaction1->type                  = Transaction::DEBIT;
                $transaction1->name                  = $transactionName;
                $transaction1->date                  = time();
                $transaction1->amount                = $amount;
                $transaction1->currency              = $currency;
                $transaction1->reference_book_id     = $debitReferenceId;
                $transaction1->counterparty_id       = $debitCounterpartyId;
                $transaction1->operation_id          = $this->operationId;
                $transaction1->operation_business_id = $businessId;

                $transaction2 = new Transaction();
                $transaction2->type                  = Transaction::CREDIT;
                $transaction2->name                  = $transactionName;
                $transaction2->date                  = time();
                $transaction2->amount                = $amount;
                $transaction2->currency              = $currency;
                $transaction2->reference_book_id     = $creditReferenceId;
                $transaction2->counterparty_id       = $creditCounterpartyId;
                $transaction2->operation_id          = $this->operationId;
                $transaction2->operation_business_id = $businessId;
                $transaction2->setScenario(Transaction::SCENARIO_TRANSACTION_CREATE);
                $transaction1->setScenario(Transaction::SCENARIO_TRANSACTION_CREATE);
                if ($transaction1->save() && $transaction2->save()) {
                    $transaction->commit();
                    $this->setData([
                        'operation' => $this->operationId
                    ]);
                } else {
                    $transaction->rollBack();
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Your transactions failed'));
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }
    }

}