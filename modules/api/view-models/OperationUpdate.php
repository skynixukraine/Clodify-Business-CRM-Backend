<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 10.11.17
 * Time: 11:06
 */

namespace viewModel;

use app\models\Operation;
use app\models\OperationType;
use app\models\Transaction;
use app\models\User;
use app\modules\api\components\Api\Processor;
use yii;
use yii\db\Exception;

class OperationUpdate extends ViewModelAbstract
{

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        if (User::hasPermission([User::ROLE_ADMIN])) {
            $operation = Operation::findOne($id);

            if ($operation) {
                if (!$operation->is_deleted) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        // all params not required
                        if (isset($this->postData['name'])) {
                            $operation->name = $this->postData['name'];
                        }
                        if (isset($this->postData['operation_type_id'])) {
                            if (OperationType::validCount($this->postData['operation_type_id'])) {
                                $operation->operation_type_id = $this->postData['operation_type_id'];
                            } else {
                                return $this->addError(Processor::ERROR_PARAM,
                                    Yii::t('app', 'Your operation_type_id is out of allowed'));
                            }
                        }
                        if (isset($this->postData['transaction_name'])) {
                            $transaction_name = $this->postData['transaction_name'];
                        }
                        if (isset($this->postData['amount'])) {
                            $amount = $this->postData['amount'];
                        }
                        if (isset($this->postData['currency'])) {
                            $currency = $this->postData['currency'];
                        }
                        if (isset($this->postData['status'])) {
                            $operation->status = $this->postData['status'];
                        }

                        $operation->date_updated = time();
                        $operation->setScenario(Operation::SCENARIO_OPERATION_UPDATE);

                        // update transaction for DEBIT
                        $transaction1 = Transaction::getDebitTransactionById($id);
                        if (isset($transaction_name)) {
                            $transaction1->name = $transaction_name;
                        }
                        if (isset($amount)) {
                            $transaction1->amount = $amount;
                        }
                        if (isset($currency)) {
                            $transaction1->currency = $currency;
                        }

                        // update transaction for CREDIT
                        $transaction2 = Transaction::getCreditTransactionById($id);
                        if (isset($transaction_name)) {
                            $transaction2->name = $transaction_name;
                        }
                        if (isset($amount)) {
                            $transaction2->amount = $amount;
                        }
                        if (isset($currency)) {
                            $transaction2->currency = $currency;
                        }

                        if ($transaction1->save() && $transaction2->save() && $operation->save()) {
                            $transaction->commit();
                        } else {
                            $transaction->rollBack();
                            return $this->addError(Processor::ERROR_PARAM,
                                Yii::t('app', 'Sorry, but the entered data is not correct and updating failed'));
                        }

                    } catch (Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM,
                        Yii::t('app', 'You are trying to update data for deleted operation'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM,
                    Yii::t('app', 'You are trying to update data for not existing operation'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM,
                Yii::t('app', 'You have no permission for this action'));
        }
    }

}
