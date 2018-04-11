<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 4.04.18
 * Time: 15:33
 */

namespace viewModel;

use app\models\ReferenceBook;
use app\models\Transaction;
use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class BalanceFetch
 * @see     https://jira.skynix.co/browse/SCA-111
 * @package viewModel
 */
class BalanceFetch extends ViewModelAbstract
{
    public function define()
    {
        if (Yii::$app->request->getQueryParam('business_id') != '') {
            if (Yii::$app->request->getQueryParam('from_date') != '') {

                if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
                    $businesId = Yii::$app->request->getQueryParam('business_id');
                    $order = Yii::$app->request->getQueryParam('order');
                    $start = Yii::$app->request->getQueryParam('start') ?: 0;
                    $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::MAX_LIMIT;
                    $fromDate = Yii::$app->request->getQueryParam('from_date');
                    $toDate = Yii::$app->request->getQueryParam('to_date');


                    $query = Transaction::find()
                        ->where(['operation_business_id' => $businesId]);

                    $dataTable = DataTable::getInstance()
                        ->setQuery($query)
                        ->setLimit($limit)
                        ->setStart($start);

                    if ($order) {
                        foreach ($order as $name => $value) {
                            $dataTable->setOrder(Transaction::tableName() . '.' . $name, $value);
                        }

                    } else {
                        $dataTable->setOrder(Transaction::tableName() . '.id', 'desc');
                    }

                    if ($fromDate) {
                        $dataTable->setFilter(Transaction::tableName() . '.date >= "' . $fromDate . '" ');
                    }

                    if ($toDate) {
                        $dataTable->setFilter(Transaction::tableName() . '.date <= "' . $toDate . '"');
                    }

                    $arr = [];
                    $references = [];

                    $transactions = $dataTable->getData();

                    $uniq = $this->unique_array($transactions,'reference_book_id' );
                    foreach ($uniq as $q) {
                        $arr[] = $q->reference_book_id;
                    }

                    if ($transactions) {
                        foreach ($arr as $k => $v) {
                                $references[$arr[$k]] = [
                                    "code" => $v,
                                    "name" => ReferenceBook::findOne($v)->name,
                                    "debit" => Transaction::getSumDebits($transactions, $v),
                                    "credit" => Transaction::getSumCredits($transactions, $v)
                                ];
                            }
                    } else {
                        $references = [];
                    }
                    $data = [
                        'references' => $references,
                        'total_records' => count($arr)
                    ];

                    $this->setData($data);

                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You should provide date from'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You should provide business_id'));
        }
    }

    /**
     * @param $array
     * @param $key
     * @return array
     * create array unique for any single key index
     */
    public function unique_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}