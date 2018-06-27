<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 5.04.18
 * Time: 16:33
 */

namespace viewModel;

use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class ResourceFetch
 * @see     https://jira.skynix.co/browse/SCA-125
 * @package viewModel
 */
class ResourceFetch extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_DEV, User::ROLE_SALES, User::ROLE_PM])) {
            $order = Yii::$app->request->getQueryParam('order');
            $start = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;

            $query = User::find()
                ->where(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_PM], 'is_active' => 1, 'is_delete' => 0])
                ->with('availabilityLog');

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(User::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(User::tableName() . '.id', 'desc');
            }

            $resources = $dataTable->getData();

            if ($resources) {
                foreach ($resources as $k => $v) {
                    $resources[$k] = [
                        "id" => $v->id,
                        "first_name"    => $v->first_name,
                        "last_name"     => $v->last_name,
                        "skills"        => $v->tags,
                        "is_available"  => $v->is_available ? true : false,
                        "available_for" => $v->is_available ? (time() - $v->availabilityLog->date) : null
                    ];
                }
            } else {
                $resources = [];
            }
            $data = [
                'resources' => $resources,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}