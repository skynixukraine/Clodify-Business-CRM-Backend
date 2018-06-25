<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 22.08.17
 * Time: 15:33
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\FixedAssetOperation;
use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\FixedAsset;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class FixedAssetFetch
 * @see     https://jira.skynix.co/browse/SCA-110
 * @package viewModel
 */
class FixedAssetFetch extends ViewModelAbstract
{
    public function define()
    {
        if (Yii::$app->request->getQueryParam('business_id') != '') {

            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
                $businesId = Yii::$app->request->getQueryParam('business_id');
                $order = Yii::$app->request->getQueryParam('order');
                $start = Yii::$app->request->getQueryParam('start') ?: 0;
                $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
                $keyword = Yii::$app->request->getQueryParam('search_query');
                $fromDate = Yii::$app->request->getQueryParam('from_date');
                $toDate = Yii::$app->request->getQueryParam('to_date');

                $query = FixedAsset::find()
                    ->leftJoin(FixedAssetOperation::tableName(), FixedAssetOperation::tableName() . '.fixed_asset_id=' . FixedAsset::tableName() . '.id')
                    ->andWhere(FixedAssetOperation::tableName() . '.operation_business_id=' . $businesId)
                    ->groupBy(FixedAsset::tableName() . '.id');

                $dataTable = DataTable::getInstance()
                    ->setQuery($query)
                    ->setLimit($limit)
                    ->setStart($start)
                    ->setSearchValue( $keyword )
                    ->setSearchParams(['or',
                        ['like', 'name', $keyword],
                        ['like', 'amortization_method', $keyword]
                    ]);

                if ($order) {
                    foreach ($order as $name => $value) {
                        $dataTable->setOrder(FixedAsset::tableName() . '.' . $name, $value);
                    }

                } else {
                    $dataTable->setOrder(FixedAsset::tableName() . '.id', 'desc');
                }

                if ($fromDate) {
                    $dataTable->setFilter(FixedAsset::tableName() . '.date_of_purchase >= "' . DateUtil::convertData($fromDate) . '" ');
                }

                if ($toDate) {
                    $dataTable->setFilter(FixedAsset::tableName() . '.date_of_purchase <= "' . DateUtil::convertData($toDate) . '"');
                }

                $fixedAsset = $dataTable->getData();

                if ($fixedAsset) {

                    foreach ($fixedAsset as $key => $fixAs) {
                        $fixedAsset[$key] = [
                            "id" => $fixAs->id,
                            "name" => $fixAs->name,
                            "cost" => $fixAs->cost,
                            "inventory_number" => $fixAs->inventory_number,
                            "amortization_method" => $fixAs->amortization_method,
                            "date_of_purchase" => $fixAs->date_of_purchase,
                            "date_write_off" => $fixAs->date_write_off
                        ];
                    }

                } else {
                    $fixedAsset = [];
                }
                $data = [
                    'fixed_assets' => $fixedAsset,
                    'total_records' => DataTable::getInstance()->getTotal()
                ];

                $this->setData($data);

            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You should provide business_id'));
        }
    }
}