<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 08.11.17
 * Time: 13:21
 */

namespace viewModel;

use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\OperationType;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class OperationTypeFetch
 * @see     https://jira.skynix.company/browse/SCA-49
 * @package viewModel
 */
class OperationTypeFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            $order = Yii::$app->request->getQueryParam('order');
            $start = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
            $keyword = Yii::$app->request->getQueryParam('search_query');

            $query = OperationType::find();

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start) ->setSearchValue($keyword)
                ->setSearchParams([ 'or',
                    ['like', 'name', $keyword]
                ]);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(OperationType::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(OperationType::tableName() . '.id', 'desc');
            }

            $operationType = $dataTable->getData();

            if ($operationType) {

                foreach ($operationType as $key => $oType) {
                    $operationType[$key] = [
                        'id' => $oType->id,
                        'name' => $oType->name
                    ];
                }

            } else {
                $operationType = [];
            }

            $data = [
                'operation-types' => $operationType,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

}
