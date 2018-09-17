<?php
/**
 * Created by Skynix Team
 * Date: 15.09.17
 * Time: 12:00
 */

namespace viewModel;


use app\components\DateUtil;
use app\models\FinancialReport;
use app\models\FinancialYearlyReport;
use app\models\SalaryReport;
use app\models\SalaryReportList;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class FinancialReportCreate
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-23
 * @author  Igor (Skynix)
 */
class FinancialReportUnlock extends ViewModelAbstract
{

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN])) {

            $id = Yii::$app->request->getQueryParam('id');
            $financialReport = FinancialReport::findOne($id);

            $finReportRange = DateUtil::getUnixMonthDateRangesByDate($financialReport->report_date);

            $financialReport->is_locked = FinancialReport::NOT_LOCKED;
            $financialReport->save();

            $salaryReport = SalaryReport::findSalaryReport($financialReport);
            if ($salaryReport) {
                $salaryReport->currency_rate = 0;
                $salaryReport->total_salary = 0;
                $salaryReport->official_salary = 0;
                $salaryReport->bonuses = 0;
                $salaryReport->hospital = 0;
                $salaryReport->day_off = 0;
                $salaryReport->overtime = 0;
                $salaryReport->other_surcharges = 0;
                $salaryReport->subtotal = 0;
                $salaryReport->total_to_pay = 0;
                $salaryReport->save();
            }

            if ($finyearrep = FinancialYearlyReport::findYearlyReport(date('Y', $finReportRange->from))) {

                $financialReports = FinancialReport::find()
                    ->andWhere(['>=', 'report_date', $finReportRange->from])
                    ->andWhere(['<=', 'report_date', $finReportRange->to])
                    ->andWhere(['is_locked' => FinancialReport::LOCKED])
                    ->all();

                $income = $expense_constant = $investments = $profit = $balance = 0;
                $expense_salary = $difference = $bonuses = $corp_events = $spent_corp_events = 0;

                foreach ($financialReports as $finRep) {
                    $id = $finRep->id;
                    $income += FinancialReport::sumIncome($id);
                    $expense_constant += FinancialReport::sumExpenseConstant($id);
                    $investments += FinancialReport::sumInvestments($id);
                    $expense_salary += FinancialReport::getExpenseSalary($id);
                    $difference += FinancialYearlyReport::getDifference($id);
                    $bonuses += FinancialYearlyReport::getBonuses($id);
                    $corp_events += FinancialYearlyReport::getCorpEvents($id);
                    $profit += FinancialYearlyReport::getYearlyProfit($id);
                    $balance += FinancialReport::getBalance($id);
                    $spent_corp_events += FinancialReport::sumSpentCorpEvents($id);
                }

                $finyearrep->income = $income;
                $finyearrep->expense_constant = $expense_constant;
                $finyearrep->investments = $investments;
                $finyearrep->expense_salary = $expense_salary;
                $finyearrep->difference = $difference;
                $finyearrep->bonuses = $bonuses;
                $finyearrep->corp_events = $corp_events;
                $finyearrep->profit = $profit;
                $finyearrep->balance = $balance;
                $finyearrep->spent_corp_events = $spent_corp_events;

                if (!$finyearrep->validate() || !$finyearrep->save()) {
                    foreach ($finyearrep->getErrors() as $param=> $errors) {
                        foreach ( $errors as $error )
                            $this->addError( $param , Yii::t('app', $error));
                    }
                }

            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

}