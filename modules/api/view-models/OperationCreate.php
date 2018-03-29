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
                $bussiness_id = $this->postData['bussiness_id'];
                $name = $this->postData['name'];
                $operation_type_id = $this->postData['operation_type_id'];
                $transaction_name = $this->postData['transaction_name'];
                $amount = $this->postData['amount'];
                $currency = $this->postData['currency'];
                $debit_reference_id = $this->postData['debit_reference_id'];
                $credit_reference_id = $this->postData['credit_reference_id'];
                $debit_counterparty_id = $this->postData['debit_counterparty_id'];
                $credit_counterparty_id = $this->postData['credit_counterparty_id'];

                // fixed_asset parametrs
                $fixed_asset_name = $this->postData['fixed_asset']['name'];
                $fixed_asset_cost = $this->postData['fixed_asset']['cost'];
                $fixed_asset_inventory_number = $this->postData['fixed_asset']['inventory_number'];
                $fixed_asset_amortization_method = $this->postData['fixed_asset']['amortization_method'];
                $fixed_asset_date_of_purchase = $this->postData['fixed_asset']['date_of_purchase'];

                // create operation
                $operation = new Operation();
                $operation->business_id = $bussiness_id;
                $operation->name = $name;
                $operation->status = Operation::DONE;
                $operation->date_created = time();
                $operation->operation_type_id = $operation_type_id;
                $operation->setScenario(Operation::SCENARIO_OPERATION_CREATE);
                if ($operation->validate() && $operation->save()) {
                    $this->operationId = $operation->id;
                    // create new fixed_asset if it exist in POST
                    if (isset($this->postData['fixed_asset'])) {
                        $fixed_asset = new FixedAsset();
                        $fixed_asset->name = $fixed_asset_name;
                        $fixed_asset->cost = $fixed_asset_cost;
                        $fixed_asset->inventory_number = $fixed_asset_inventory_number;
                        $fixed_asset->amortization_method = $fixed_asset_amortization_method;
                        $fixed_asset->date_of_purchase = $fixed_asset_date_of_purchase;
                        if ($fixed_asset->validate() && $fixed_asset->save()) {
                            // create new fixed_assets_operation
                            $fixed_assets_operation = new FixedAssetOperation();
                            $fixed_assets_operation->fixed_asset_id = $fixed_asset->id;
                            $fixed_assets_operation->operation_id = $this->operationId;
                            $fixed_assets_operation->operation_business_id = $operation->business_id;
                            if ($fixed_assets_operation->validate()) {
                                $fixed_assets_operation->save();
                            } else {
                                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Creating fixed_assets_operation failed'));
                            }
                        } else {
                            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Creating fixed_asset failed'));
                        }
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Your operation failed'));
                }

                // create two transactions for DEBIT and CREDIT
                $transaction1 = new Transaction();
                $transaction1->type = Transaction::DEBIT;
                $transaction1->name = $transaction_name;
                $transaction1->date = time();
                $transaction1->amount = $amount;
                $transaction1->currency = $currency;
                $transaction1->reference_book_id = $debit_reference_id;
                $transaction1->counterparty_id = $debit_counterparty_id;
                $transaction1->operation_id = $this->operationId;
                $transaction1->operation_business_id = $bussiness_id;

                $transaction2 = new Transaction();
                $transaction2->type = Transaction::CREDIT;
                $transaction2->name = $transaction_name;
                $transaction2->date = time();
                $transaction2->amount = $amount;
                $transaction2->currency = $currency;
                $transaction2->reference_book_id = $credit_reference_id;
                $transaction2->counterparty_id = $credit_counterparty_id;
                $transaction2->operation_id = $this->operationId;
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