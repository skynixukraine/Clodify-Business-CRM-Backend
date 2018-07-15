<?php
/**
 * Created by Skynix Team
 * Date: 3.0.17
 * Time: 12:00
 */

namespace viewModel;


use app\models\DelayedSalary;
use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\FinancialYearlyReport;
use app\models\Milestone;
use app\models\Project;
use app\models\Report;
use app\models\SalaryReport;
use app\models\SalaryReportList;
use app\models\User;
use app\models\WorkHistory;
use app\modules\api\components\Api\Processor;
use Yii;
use yii\log\Logger;

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
            $year = date("Y", $financialReport->report_date);

            if ($financialReport) {
                if (!$financialReport->is_locked) {

                    $salaryReport = SalaryReport::findSalaryReport($financialReport);
                    if ($salaryReport) {
                        $salaryReportLists = SalaryReportList::findAll([
                            'salary_report_id' => $salaryReport->id,
                        ]);
                        $salaryReport->currency_rate = $financialReport->currency;
                        $salaryReport->total_salary = SalaryReportList::getSumOf($salaryReportLists, 'subtotal_uah');
                        $salaryReport->official_salary = SalaryReportList::getSumOf($salaryReportLists, 'official_salary');
                        $salaryReport->bonuses = SalaryReportList::getSumByCurrency($salaryReportLists, 'bonuses');
                        $salaryReport->hospital = SalaryReportList::getSumByCurrency($salaryReportLists, 'hospital_value');
                        $salaryReport->day_off = SalaryReportList::getSumOf($salaryReportLists, 'day_off');
                        $salaryReport->overtime = SalaryReportList::getSumByCurrency($salaryReportLists, 'overtime_value');
                        $salaryReport->other_surcharges = SalaryReportList::getSumByCurrency($salaryReportLists, 'other_surcharges');
                        $salaryReport->subtotal = SalaryReportList::getSumOf($salaryReportLists, 'subtotal');
                        $salaryReport->total_to_pay = SalaryReportList::getSumOf($salaryReportLists, 'total_to_pay');
                        $salaryReport->save();
                    }

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
                            if($financialReport->save()){
                                $this->applyDelayedSalary($financialReport->report_date);
                            }
                        } else {
                            foreach ($finyearrep->getErrors() as $param=> $errors) {
                                foreach ( $errors as $error )
                                    $this->addError( $param , Yii::t('app', $error));
                            }
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
                        if ($yearlyReport->save()) {
                            $financialReport->is_locked = FinancialReport::LOCKED;
                            if($financialReport->save()){
                                $this->applyDelayedSalary($financialReport->report_date);
                            }
                        } else {
                            foreach ($yearlyReport->getErrors() as $param=> $errors) {
                                foreach ( $errors as $error )
                                    $this->addError( $param , Yii::t('app', $error));
                            }
                        }
                    }
                    Yii::getLogger()->log('Applying Financial Income Histories', Logger::LEVEL_INFO);
                    $dateFrom   = date('Y-m-01 00:00:00', $financialReport->report_date);
                    $toDate     = date('Y-m-t 00:00:00', $financialReport->report_date);

                    $query  = FinancialIncome::find();
                    $query->where(['financial_report_id' => $financialReport->id]);
                    $query->groupBy('developer_user_id');
                    $query->select(['SUM(amount) AS sumAmount', 'developer_user_id']);
                    $data = $query->all();

                    /** @var  $finIncome FinancialIncome */
                    foreach ( $data as $finIncome ) {


                        if ( ( $user = User::findOne($finIncome->developer_user_id ) ) ) {

                            $earned = round(($finIncome->sumAmount - Report::getReportCostPerMonthPerUser( $finIncome->developer_user_id )) * 0.8 );

                            WorkHistory::create(
                                WorkHistory::TYPE_USER_EFFORTS,
                                $finIncome->developer_user_id,
                                Yii::t('app', '~ Earned ${earned}', [
                                    'earned'  => $earned
                                ]),
                                $dateFrom,
                                $toDate
                            );

                        }
                    }
                    /**
                     * @see https://jira.skynix.co/browse/SCA-215
                     * When locking a fun report, if end_date >= closed_date → benefits (User X get the project Y/Milestone XY completed in time)
                     * When locking a fun report, if end_date < closed_date → fail (User X did not get the project Y/Milestone XY completed in time)
                     */
                    $dateFrom   = date('Y-m-01', $financialReport->report_date);
                    $toDate     = date('Y-m-t', $financialReport->report_date);
                    if ( ($milestones = Milestone::findAll([
                        'between', 'closed_date', $dateFrom, $toDate
                    ]) ) ) {

                        /** @var $milestone Milestone */
                        foreach ( $milestones as $milestone ) {

                            $developers = [];
                            /** @var $project Project */
                            if ( ( $project = $milestone->getProject()->one() ) &&
                                ( $developers = $project->getDevelopers()->all() ) ) {

                                /** @var $dev User */
                                foreach ( $developers as $dev ) {

                                    if ( strtotime( $milestone->end_date ) >= strtotime($milestone->closed_date) ) {

                                        WorkHistory::create(
                                            WorkHistory::TYPE_USER_EFFORTS,
                                            $dev->id,
                                            Yii::t('app', '+ get the project ${project}/${milestone} completed in time', [
                                                'project'   => $project->name,
                                                'milestone' => $milestone->name
                                            ]),
                                            $dateFrom,
                                            $toDate
                                        );

                                    } else {

                                        WorkHistory::create(
                                            WorkHistory::TYPE_USER_FAILS,
                                            $dev->id,
                                            Yii::t('app', '- did not get the project ${project}/${milestone} completed in time', [
                                                'project'   => $project->name,
                                                'milestone' => $milestone->name
                                            ]),
                                            $dateFrom,
                                            $toDate
                                        );

                                    }

                                }

                            }

                        }

                    }


                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to add twise the same report'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to add not existent report'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

    /**
     * @param $finRep
     * We should apply salary always for next period following after the fin report
     * find delayed_salary where is_applied=0 and Locked FIN Report month = delayed_salary→month
     * set user's salary column = delayed_salary→value
     * set delayed_salary`s is_applied=1
     */
    public function applyDelayedSalary( $date )
    {
        Yii::getLogger()->log('applyDelayedSalary', Logger::LEVEL_INFO);

        $date = date('Y-m-d', $date);
        $m = date("m", strtotime($date . ' +1 month')); //Applying salaries for next period
        $records =  DelayedSalary::find()->where(['is_applied' => 0, 'month' => $m])->all();

        Yii::getLogger()->log('DelayedSalary Month: ' . $m, Logger::LEVEL_INFO);
        Yii::getLogger()->log('DelayedSalary Records: ' . count($records), Logger::LEVEL_INFO);
        if($records){
            /** @var  $record DelayedSalary */
            foreach ($records as $record){

                /** @var $user User */
                if ( ( $user = $record->getUser()->one() ) ) {

                    Yii::getLogger()->log('DelayedSalary Applied : ' . $record->value, Logger::LEVEL_INFO);

                    $user->salary = $record->value;
                    $user->save(false, ['salary']);

                }
                $record->is_applied = 1;
                $record->save(false, ['is_applied']);
            }
        }
    }

    public function render()
    {
        parent::render(); // TODO: Change the autogenerated stub
    }
}