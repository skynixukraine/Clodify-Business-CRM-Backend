<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/9/18
 * Time: 11:22 PM
 */

namespace viewModel;

use app\components\DataTable;
use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * @see https://jira.skynix.co/browse/SCA-177
 * Class FinancialIncomeFetch
 * @package viewModel
 */
class FinancialIncomeFetch extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            if ( ($id = Yii::$app->request->getQueryParam('id') ) &&
                ( $financialReport = FinancialReport::findOne($id) )) {
                    $order    = Yii::$app->request->getQueryParam('order');
                    $start    = Yii::$app->request->getQueryParam('start', 0);
                    $limit    = Yii::$app->request->getQueryParam('limit', 10000);
                    $keyword    = Yii::$app->request->getQueryParam('search_query');

                    $query  = FinancialIncome::find();
                    $query->where(['financial_report_id' => $financialReport->id]);
                    if ( User::hasPermission([User::ROLE_SALES]) ) {

                        $query->andWhere(['added_by_user_id' => Yii::$app->user->id]);
                    }
                    $dataTable = DataTable::getInstance()
                        ->setQuery($query)
                        ->setLimit($limit)
                        ->setStart($start);

                    if ($order) {
                        foreach ($order as $name => $value) {
                            $dataTable->setOrder(FinancialIncome::tableName() . '.' . $name, $value);
                        }

                    } else {
                        $dataTable->setOrder(FinancialIncome::tableName() . '.id', 'desc');
                    }
                    $incomeItems    = [];
                    if ( ( $data = $dataTable->getData() ) )  {

                        /** @var  $finIncome FinancialIncome */
                        foreach ( $data as $finIncome ) {

                            $incomeItems[] = [
                                'id'        => $finIncome->id,
                                'amount'    => $finIncome->amount,
                                'date'      => $finIncome->date,
                                'description'   => $finIncome->description,
                                'project_id'    => $finIncome->project_id,
                                'developer_user_id' => $finIncome->developer_user_id,
                                'added_by_user_id'  => $finIncome->added_by_user_id

                            ];

                        }
                    }
                    $this->setData($incomeItems);
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to fetch income for not existent financial report'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}