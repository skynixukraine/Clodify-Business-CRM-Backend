<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 08.11.17
 * Time: 11:50
 */

namespace viewModel;

use app\models\Business;
use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class BusinessFetch
 * @see     https://jira.skynix.company/browse/SCA-54
 * @package viewModel
 */
class BusinessFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            $order = Yii::$app->request->getQueryParam('order');
            $start = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;

            $query = Business::find();

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(Business::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(Business::tableName() . '.id', 'desc');
            }

            $business = $dataTable->getData();

            if ($business) {

                foreach ($business as $key => $busi) {
                    $business[$key] = [
                        'id' => $busi->id,
                        'name' => $busi->name
                    ];
                }

            } else {
                $business = [];
            }

            $data = [
                'businesses' => $business,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

}
