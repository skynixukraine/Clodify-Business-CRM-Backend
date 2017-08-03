<?php
/**
 * Created by Skynix Team
 * Date: 25.07.17
 * Time: 13:48
 */

namespace viewModel;

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
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
            $order = Yii::$app->request->getQueryParam('order');
            $start = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;

            $query = FinancialReport::find();

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
                    $financialReport[$key] = [
                        'id' => $finRep->id,
                        'report_date' => $this->dateRangeForFetch($finRep->report_date),
                        'balance' => FinancialReport::getBalance($finRep->id),
                        'currency' => $finRep->currency ? $finRep->currency : 0,
                        'expenses' => FinancialReport::sumExpenses($finRep->id),
                        'investments' => FinancialReport::sumInvestments($finRep->id),
                        'spent_corp_events' => FinancialReport::sumSpentCorpEvents($finRep->id),
                        'is_locked' => $finRep->is_locked
                    ];
                    if (User::hasPermission([User::ROLE_ADMIN])) {
                        $financialReport[$key]['income'] = FinancialReport::sumIncome($finRep->id);
                        $financialReport[$key]['profit'] = FinancialReport::getProfit($finRep->id);
                    }
                }

            } else {
                $financialReport = [];
            }
            $data = [
                'reports' => $financialReport,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

    /**
     * @param $date
     * @return string
     *  return something like that 01/01/2016 ~ 31/01/2016
     */
    private function dateRangeForFetch($date)
    {
        $range = '';
        $month_from_date = date('m', $date);
        $year_from_date = date('Y',$date);
        $count_of_days = date("t",mktime(0,0,0,$month_from_date ,1,$year_from_date));
        $range .= '01/'. $month_from_date . '/' . $year_from_date ;
        $range .= ' ~ ' . $count_of_days . '/' .$month_from_date . '/' . $year_from_date;
        return $range;
    }
}

