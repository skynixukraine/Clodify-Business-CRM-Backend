<?php
/**
 * Created by Skynix Team
 * Date: 18.04.18
 * Time: 17:28
 */

namespace viewModel;

use app\models\Operation;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\User;

/**
 * Class OperationView
 * @package viewModel
 */
class OperationView extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {

            $id = Yii::$app->request->getQueryParam('id');
            $operation = Operation::find()
                ->andWhere(['id' => $id])
                ->with('business', 'operationType', 'transactions')
                ->one();

            if ($operation) {
                if (!$operation->is_deleted) {

                    $operationData = [
                        'id' => $operation->id,
                        'name' => $operation->name,
                        'status' => $operation->status,
                        'date_created' => $operation->date_created,
                        'date_updated' => $operation->date_updated,
                        'operation_type' =>
                            [
                                $operation->operationType->id,
                                $operation->operationType->name,
                            ],
                        'business' =>
                            [
                                $operation->business->id,
                                $operation->business->name,
                            ]
                    ];

                    $transactions = [];
                    foreach ($operation->transactions as $k => $t) {
                        $transactions[$k] = [
                            'id' => $t->id,
                            'type' => $t->type,
                            'name' => $t->name,
                            'date' => $t->date,
                            'amount' => $t->amount,
                            'currency' => $t->currency,
                            'reference_book' =>
                                [
                                    'id' => $t->referenceBook->id,
                                    'name' => $t->referenceBook->name,
                                ]
                        ];
                    }

                    $operationData['transactions'] = $transactions;
                    $this->setData($operationData);
                } else {
                    $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Operation is deleted'));
                }
            } else {
                $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Operation not existing'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}