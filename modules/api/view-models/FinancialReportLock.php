<?php
/**
 * Created by Skynix Team
 * Date: 3.0.17
 * Time: 12:00
 */

namespace viewModel;


use app\components\DateUtil;
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
//income - int (a sum of all month's income amounts)
//expense_constant - int (a sum of all month's expense_constant amounts)
//investments - int (a sum of all month's investments amounts)
//expense_salary - int
//currency - int
//difference - int ( income - expense_constant)
//bonuses - int ( 10% of difference )
//corp_events - int ( 10% of difference )
//profit - int (  difference - bonuses - corp_events )
//balance - int ( profit - investments )
//spent_corp_events - int

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN])) {
            $id = Yii::$app->request->getQueryParam('id');
            $financialReport = FinancialReport::findOne($id);

            if ($finyearrep = FinancialYearlyReport::isYearlyReportExist()) {                 //add to current year
                $finyearrep->income += FinancialReport::sumIncome($id);
                $finyearrep->expense_constant += FinancialReport::sumExpenseConstant($id);
                $finyearrep->investments += FinancialReport::sumInvestments($id);
                $finyearrep->expense_salary += FinancialReport::getExpenseSalary($id);
                $finyearrep->difference += FinancialYearlyReport::getDifference($id);
                $finyearrep->bonuses += FinancialYearlyReport::getBonuses($id);
                $finyearrep->corp_events += FinancialYearlyReport::getCorpEvents($id);
                $finyearrep->profit += FinancialYearlyReport::getYearlyProfit($id);
                $finyearrep->balance += FinancialReport::getBalance($id);
               // $finyearrep->spent_corp_events += FinancialYearlyReport::getCorpEvents($id);

                if ($this->validate() && $finyearrep->save()) {
                    $financialReport->is_locked = 1;
                    $financialReport->save();
                }

            } else {
                $yearlyReport = new FinancialYearlyReport();                  // create new yearly report
                $yearlyReport->year = date("Y");
                $yearlyReport->income = FinancialReport::sumIncome($id);
                $yearlyReport->expense_constant = FinancialReport::sumExpenseConstant($id);
                $yearlyReport->investments = FinancialReport::sumInvestments($id);
                $yearlyReport->expense_salary = FinancialReport::getExpenseSalary($id);
                $yearlyReport->difference = FinancialYearlyReport::getDifference($id);
                $yearlyReport->bonuses = FinancialYearlyReport::getBonuses($id);
                $yearlyReport->corp_events = FinancialYearlyReport::getCorpEvents($id);
                $yearlyReport->profit = FinancialYearlyReport::getYearlyProfit($id);
                $yearlyReport->balance = FinancialReport::getBalance($id);
                // here must be $yearlyReport->spent_corp_events
                $yearlyReport->save();
                $financialReport->is_locked = 1;
                $financialReport->save();
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

//    private function isYearlyReportExist()
//    {
//        $finyearrep = FinancialYearlyReport::find()
//            ->where(['year=:x', [':x' => date("Y")]])
//            ->one();
//        return $finyearrep;
//    }


}