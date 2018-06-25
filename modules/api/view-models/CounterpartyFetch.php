<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 07.11.17
 * Time: 14:47
 */

namespace viewModel;

use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\Counterparty;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class CounterpartyFetch
 * @see     https://jira.skynix.company/browse/SCA-46
 * @package viewModel
 */
class CounterpartyFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            $order = Yii::$app->request->getQueryParam('order');
            $start = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
            $keyword = Yii::$app->request->getQueryParam('search_query');

            $query = Counterparty::find();

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start)
                ->setSearchValue($keyword)
                ->setSearchParams([ 'or',
                    ['like', 'name', $keyword]
                ]);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(Counterparty::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(Counterparty::tableName() . '.id', 'desc');
            }

            $counterparty = $dataTable->getData();

            if ($counterparty) {

                foreach ($counterparty as $key => $cParty) {
                    $counterparty[$key] = [
                        'id' => $cParty->id,
                        'name' => $cParty->name
                    ];
                }

            } else {
                $counterparty = [];
            }

            $data = [
                'counterparties' => $counterparty,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

}

