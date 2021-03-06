<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 29.02.18
 * Time: 16:21
 */

namespace viewModel;

use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\components\DateUtil;
use app\models\Operation;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class OperationFetch
 * @see     https://jira.skynix.co/browse/SCA-99
 * @package viewModel
 */
class OperationFetch extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            $order             = Yii::$app->request->getQueryParam('order');
            $start             = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit             = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
            $keyword           = Yii::$app->request->getQueryParam('search_query');
            $dateStart         = Yii::$app->request->getQueryParam('from_date');
            $dateEnd           = Yii::$app->request->getQueryParam('to_date');
            $operation_type_id = Yii::$app->request->getQueryParam('operation_type_id');
            $business_id       = Yii::$app->request->getQueryParam('business_id');

            $query = Operation::find()->where(['is_deleted' => 0])->with('business', 'operationType', 'transactions');

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start)->setSearchValue($keyword)
                ->setSearchParams(['or',
                    ['like', 'name', $keyword]
                ]);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(Operation::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(Operation::tableName() . '.id', 'desc');
            }

            if ($dateStart) {
                $dataTable->setFilter(Operation::tableName() . '.date_created >=' . DateUtil::convertData($dateStart));
            }

            if ($dateEnd) {
                $dataTable->setFilter(Operation::tableName() . '.date_created <=' . DateUtil::convertData($dateEnd));
            }

            if ($operation_type_id) {
                $dataTable->setFilter(Operation::tableName() . '.operation_type_id=' . $operation_type_id);
            }

            if ($business_id) {
                $dataTable->setFilter(Operation::tableName() . '.business_id=' . $business_id);
            }

            $operations = $dataTable->getData();

            if ($operations) {

                foreach ($operations as $key => $operation) {
                    $operations[$key] = [
                        'id'                => $operation->id,
                        'name'              => $operation->name,
                        'status'            => $operation->status,
                        'date_created'      => $operation->date_created,
                        'date_updated'      => $operation->date_updated,
                        'operation_type' =>
                            [
                                $operation->operationType->id,
                                $operation->operationType->name,
                            ],
                        'business'          =>
                            [
                                $operation->business->id,
                                $operation->business->name,
                            ]
                    ];

                    $transactions = [];
                    foreach ($operation->transactions as $k => $t) {
                        $transactions[$k] = [
                            'id'             => $t->id,
                            'type'           => $t->type,
                            'name'           => $t->name,
                            'date'           => $t->date,
                            'amount'         => $t->amount,
                            'currency'       => $t->currency,
                            'reference_book' =>
                                [
                                    'id'   => $t->referenceBook->id,
                                    'name' => $t->referenceBook->name,
                                ]
                        ];
                    }

                    $operations[$key]['transactions'] = $transactions;
                }

            } else {
                $operations = [];
            }

            $data = [
                'operations' => $operations,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }
    }

}