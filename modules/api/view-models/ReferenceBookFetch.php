<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 09.11.17
 * Time: 8:55
 */

namespace viewModel;

use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\ReferenceBook;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class ReferenceBookFetch
 * @see     https://jira.skynix.company/browse/SCA-51
 * @package viewModel
 */
class ReferenceBookFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            $order = Yii::$app->request->getQueryParam('order');
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
            $nameFilter = Yii::$app->request->getQueryParam('name');
            $codeFilter = Yii::$app->request->getQueryParam('code');

            $query = ReferenceBook::find();

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(ReferenceBook::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(ReferenceBook::tableName() . '.id', 'desc');
            }

            if ($nameFilter && $nameFilter != null){
                $dataTable->setFilter('name=\'' . $nameFilter . '\'');
            }

            if ($codeFilter && $codeFilter != null){
                $dataTable->setFilter('code=\'' . $codeFilter . '\'');
            }

            $refBook = $dataTable->getData();

            if ($refBook) {

                foreach ($refBook as $key => $refB) {
                    $refBook[$key] = [
                        'id' => $refB->id,
                        'name' => $refB->name,
                        'code' => $refB->code,
                    ];
                }

            } else {
                $refBook = [];
            }

            $data = [
                'references' => $refBook,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

}
