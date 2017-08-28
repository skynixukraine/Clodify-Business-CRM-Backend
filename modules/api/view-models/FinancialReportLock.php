<?php
/**
 * Created by Skynix Team
 * Date: 3.0.17
 * Time: 12:00
 */

namespace viewModel;


use app\models\FinancialReport;
use app\models\FinancialYearlyReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class FinancialReportCreate
 *
 * @package viewModel
 * @see     https://jira-v2.skynix.company/browse/SI-1031
 * @author  Igor (Skynix)
 */
class FinancialReportLock extends ViewModelAbstract
{

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN])) {
            $id = Yii::$app->request->getQueryParam('id');
            $financialReport = FinancialReport::findOne($id);
            $year = date("Y",$financialReport->report_date);
            if ($financialReport) {
                if (!$financialReport->is_locked) {

                    if ($finyearrep = FinancialYearlyReport::findYearlyReport($year)) {          //add to current year
                        $finyearrep->income += FinancialReport::sumIncome($id);
                        $finyearrep->expense_constant += FinancialReport::sumExpenseConstant($id);
                        $finyearrep->investments += FinancialReport::sumInvestments($id);
                        $finyearrep->expense_salary += FinancialReport::getExpenseSalary($id);
                        $finyearrep->difference += FinancialYearlyReport::getDifference($id);
                        $finyearrep->bonuses += FinancialYearlyReport::getBonuses($id);
                        $finyearrep->corp_events += FinancialYearlyReport::getCorpEvents($id);
                        $finyearrep->profit += FinancialYearlyReport::getYearlyProfit($id);
                        $finyearrep->balance += FinancialReport::getBalance($id);
                        $finyearrep->spent_corp_events += FinancialReport::sumSpentCorpEvents($id);
                        if ($finyearrep->validate() && $finyearrep->save()) {
                            $financialReport->is_locked = FinancialReport::LOCKED;
                            $financialReport->save();
                        }

                    } else {
                        $yearlyReport = new FinancialYearlyReport();                  // create new yearly report
                        $yearlyReport->year = $year;
                        $yearlyReport->income = FinancialReport::sumIncome($id);
                        $yearlyReport->expense_constant = FinancialReport::sumExpenseConstant($id);
                        $yearlyReport->investments = FinancialReport::sumInvestments($id);
                        $yearlyReport->expense_salary = FinancialReport::getExpenseSalary($id);
                        $yearlyReport->difference = FinancialYearlyReport::getDifference($id);
                        $yearlyReport->bonuses = FinancialYearlyReport::getBonuses($id);
                        $yearlyReport->corp_events = FinancialYearlyReport::getCorpEvents($id);
                        $yearlyReport->profit = FinancialYearlyReport::getYearlyProfit($id);
                        $yearlyReport->balance = FinancialReport::getBalance($id);
                        $yearlyReport->spent_corp_events = FinancialReport::sumSpentCorpEvents($id);
                        $yearlyReport->save();
                        $financialReport->is_locked = FinancialReport::LOCKED;
                        $financialReport->save();
                    }

                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You are trying to add twise the same report'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You are trying to add not existent report'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

}