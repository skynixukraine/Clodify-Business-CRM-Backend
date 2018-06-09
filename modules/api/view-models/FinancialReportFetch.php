<?php
/**
 * Created by Skynix Team
 * Date: 25.07.17
 * Time: 13:48
 */

namespace viewModel;

use app\models\FinancialIncome;
use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\components\DateUtil;
use app\models\FinancialReport;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class FinancialReportFetch
 * @see     https://jira-v2.skynix.company/browse/SI-1024
 * @package viewModel
 */
class FinancialReportFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
            $order    = Yii::$app->request->getQueryParam('order');
            $start    = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit    = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
            $date_raw = Yii::$app->request->getQueryParam('search_query');

            if (!empty($date_raw)){

                $dates = explode("~", $date_raw);

                if ( count($dates) === 2) {

                    $query = FinancialReport::find()
                        ->where(['between', 'report_date',
                            DateUtil::toUnixFromSlashFormat(trim($dates[0])), DateUtil::getLastDayOfMonth(trim($dates[1]))
                        ]);


                }

            } else {
                $query = FinancialReport::find();
            }

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(FinancialReport::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(FinancialReport::tableName() . '.id', 'desc');
            }

            $financialReport = $dataTable->getData();

            if ($financialReport) {

                foreach ($financialReport as $key => $finRep) {

                    $rep = [
                        'id'                  => $finRep->id,
                        'report_date'         => DateUtil::dateRangeForFetch($finRep->report_date),
                    ];

                    if (User::hasPermission([User::ROLE_SALES])) {

                        //For SALES output only income posted by themself
                        $rep['income']              = FinancialReport::sumIncome($finRep->id, Yii::$app->user->id);
                        $rep['developer_expenses']  = FinancialReport::sumDeveloperExpenses($finRep->id, Yii::$app->user->id);
                        $rep['bonuses']             = round(( $rep['income'] - $rep['developer_expenses'] ) * 0.1, 2);

                    } else {

                        $rep['balance']             = FinancialReport::getBalance($finRep->id);
                        $rep['currency']            = $finRep->currency ? $finRep->currency : 0;
                        $rep['expenses']            = FinancialReport::sumExpenses($finRep->id);
                        $rep['investments']         = FinancialReport::sumInvestments($finRep->id);
                        $rep['spent_corp_events']   = FinancialReport::sumSpentCorpEvents($finRep->id);
                        $rep['num_of_working_days'] = $finRep->num_of_working_days;
                        $rep['is_locked']   = $finRep->is_locked;

                    }
                    if (User::hasPermission([User::ROLE_ADMIN])) {
                        $rep['income'] = FinancialReport::sumIncome($finRep->id);
                        $rep['profit'] = FinancialReport::getProfit($finRep->id);
                    }
                    $financialReport[$key] = $rep;

                }

            } else {
                $financialReport = [];
            }

            $this->setData($financialReport);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

    public function render()
    {
        parent::render(); // TODO: Change the autogenerated stub
        Yii::$app->response->content = json_encode([
            'financialReport' => $this->data,
            'meta' => [
                'total' => DataTable::getInstance()->getTotal(),
                'errors' => $this->errors,
                'success' => count($this->errors) == 0 ? true : false
            ]
        ]);
    }

}

