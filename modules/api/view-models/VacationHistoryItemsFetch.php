<?php
/**
 * Create By Skynix Team
 * Author: maryna zhezhel
 * Date: 17/1/19
 * Time: 3:23 PM
 */
namespace viewModel;

use app\components\DataTable;
use app\models\VacationHistoryItem;
use Yii;
use app\modules\api\components\SortHelper;
use app\models\User;
use app\modules\api\components\Api\Processor;

class VacationHistoryItemsFetch extends ViewModelAbstract
{

    public function define()
    {
        $start = Yii::$app->request->getQueryParam('start') ?: 0;
        $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
        $year  = Yii::$app->request->getQueryParam('year') ?: date("Y");
        
        if (User::hasPermission([User::ROLE_ADMIN])) {
            $userId = Yii::$app->request->getQueryParam('user_id', Yii::$app->user->id);
        } elseif (User::hasPermission([User::ROLE_FIN, User::ROLE_DEV, User::ROLE_CLIENT, User::ROLE_SALES, User::ROLE_PM])) {
            $userId = Yii::$app->user->id;
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }
        
        $query = VacationHistoryItem::find()
        ->where([
            'between',
            'date',
            date('Y-m-d', strtotime($year . '-01-01')),
            date('Y-m-d', strtotime($year . '-12-31'))
        ])
        ->andWhere(['user_id' => $userId]);
        
        $dataTable = DataTable::getInstance()
            ->setQuery($query)
            ->setLimit($limit)
            ->setStart($start);
        
        
        $dataTable->setOrder(VacationHistoryItem::tableName() . '.id', 'desc');
        
        $vacationHistoryItems = $dataTable->getData();

        $vacationHistoryItemsData = array();
        if ($vacationHistoryItems) {
            foreach ($vacationHistoryItems as $vacationHistoryItem) {
                $user = $vacationHistoryItem->getUser()->one();
                $vacationHistoryItemsData [] = [
                    'id' => $vacationHistoryItem->id,
                    'user' => [
                        'id'         => $user->id,
                        'first_name' => $user->first_name,
                        'last_name'  => $user->last_name
                    ],
                    'days' => $vacationHistoryItem->days,
                    'month' => date('M', strtotime($vacationHistoryItem->date))
                ];
            }
        } else {
            $vacationHistoryItemsData = array();
        }
        $data = [
            'vacationHistoryItems' => $vacationHistoryItemsData,
            'total_records' => DataTable::getInstance()->getTotal(),
        ];
        $this->setData($data);
    }
}