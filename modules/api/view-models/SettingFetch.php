<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 19.10.17
 * Time: 13:51
 */

namespace viewModel;

use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\components\DateUtil;
use app\models\Setting;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class FinancialReportFetch
 * @see    https://jira.skynix.company/browse/SCA-39
 * @package viewModel
 */
class SettingFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {
            $order = Yii::$app->request->getQueryParam('order');
            $start = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;

            $query = Setting::find();

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(Setting::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(Setting::tableName() . '.id', 'asc');
            }

            $settings = $dataTable->getData();

            if ($settings) {

                foreach ($settings as $key => $set) {
                    $settings[$key] = [
                        'id' => $set->id,
                        'key' => $set->key,
                        'value' => $set->value,
                        'type' => $set->type
                    ];
                }
            } else {
                $settings = [];
            }

            $this->setData($settings);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

}
