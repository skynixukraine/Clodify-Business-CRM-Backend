<?php
/**
 * Created by Skynix Team
 * Date: 3.0.17
 * Time: 12:00
 */

namespace viewModel;


use app\components\DateUtil;
use app\models\DelayedSalary;
use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\FinancialYearlyReport;
use app\models\Milestone;
use app\models\Project;
use app\models\ProjectDebt;
use app\models\Report;
use app\models\SalaryReport;
use app\models\SalaryReportList;
use app\models\User;
use app\models\WorkHistory;
use app\models\VacationHistoryItem;
use app\models\Setting;
use app\modules\api\components\Api\Processor;
use Yii;
use yii\helpers\ArrayHelper;
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
            $year = date("Y", strtotime( $financialReport->report_date));

            if ($financialReport) {
                if (!$financialReport->is_locked) {

                    //Create next Fin Report if not created
                    $sRepDate = date("Y-m-01", strtotime( $financialReport->report_date . ' +1month'));
                    $eRepDate = date("Y-m-t", strtotime( $financialReport->report_date . ' +1month'));
                    if ( !($nextFinRep = FinancialReport::find()->where(['between', 'report_date', $sRepDate, $eRepDate])->one()) ) {

                        $nextFinRep = new FinancialReport();
                        $nextFinRep->report_date = $sRepDate;
                        $nextFinRep->save(false);

                    }

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
                        Yii::getLogger()->log('Fin Year Report exists', Logger::LEVEL_INFO);
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
                            Yii::getLogger()->log('SAVED BOTH REPORTS', Logger::LEVEL_INFO);
                            $financialReport->is_locked = FinancialReport::LOCKED;
                            if($financialReport->save()){
                                $this->applyDelayedSalary($financialReport->report_date);
                            }
                        } else {
                            foreach ($finyearrep->getErrors() as $param=> $errors) {
                                foreach ( $errors as $error )
                                    $this->addError( $param , Yii::t('app', $error));
                            }
                            Yii::getLogger()->log('Fin Year Report Errors: ' .var_export($finyearrep->getErrors(), 1), Logger::LEVEL_INFO);
                            Yii::getLogger()->log('Fin Report Errors: ' .var_export($financialReport->getErrors(), 1), Logger::LEVEL_INFO);

                        }

                    } else {
                        Yii::getLogger()->log('NEW Fin Year Report exists', Logger::LEVEL_INFO);
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
                            Yii::getLogger()->log('SAVED Year Report', Logger::LEVEL_INFO);
                            $financialReport->is_locked = FinancialReport::LOCKED;
                            if($financialReport->save()){
                                Yii::getLogger()->log('SAVED Fin Report', Logger::LEVEL_INFO);
                                $this->applyDelayedSalary($financialReport->report_date);
                            } else {

                                Yii::getLogger()->log('Fin  Report Errors: ' .var_export($financialReport->getErrors(), 1), Logger::LEVEL_INFO);
                            }
                        } else {
                            foreach ($yearlyReport->getErrors() as $param=> $errors) {
                                foreach ( $errors as $error )
                                    $this->addError( $param , Yii::t('app', $error));
                            }
                            Yii::getLogger()->log('Fin Year Report Errors: ' .var_export($yearlyReport->getErrors(), 1), Logger::LEVEL_INFO);

                        }
                    }
                    $finReportRange = DateUtil::getUnixMonthDateRangesByDate($financialReport->report_date);
                    Yii::getLogger()->log('Applying Financial Income Histories', Logger::LEVEL_INFO);

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
                                $finReportRange->fromDate,
                                $finReportRange->toDate
                            );

                        }
                    }
                    /**
                     * @see https://jira.skynix.co/browse/SCA-215
                     * When locking a fun report, if end_date >= closed_date → benefits (User X get the project Y/Milestone XY completed in time)
                     * When locking a fun report, if end_date < closed_date → fail (User X did not get the project Y/Milestone XY completed in time)
                     */
                    if ( ($milestones = Milestone::find()->where([
                        'between', 'closed_date', $finReportRange->fromDate, $finReportRange->toDate
                    ])->orderBy('project_id ASC')->all() ) ) {
                        $currentMilestone   = null;
                        $dateFrom           = $finReportRange->fromDate;
                        $toDate             = $finReportRange->toDate;
                        Yii::getLogger()->log('Found ' . count($milestones) . ' closed milestones', Logger::LEVEL_INFO);
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
                                            $finReportRange->fromDate,
                                            $finReportRange->toDate
                                        );

                                    } else {

                                        WorkHistory::create(
                                            WorkHistory::TYPE_USER_FAILS,
                                            $dev->id,
                                            Yii::t('app', '- did not get the project ${project}/${milestone} completed in time', [
                                                'project'   => $project->name,
                                                'milestone' => $milestone->name
                                            ]),
                                            $finReportRange->fromDate,
                                            $finReportRange->toDate
                                        );

                                    }

                                }
                                if ( !$currentMilestone ) {

                                    $dateFrom   = $finReportRange->fromDate;
                                    $toDate     = $finReportRange->toDate;
                                    $currentMilestone = $milestone;

                                } else if ( $milestone->project_id != $currentMilestone->project_id ) {

                                    /**
                                     * @see https://jira.skynix.co/browse/SCA-271
                                     * When a Financial Report is locked and period has any closed milestones, check debts -> if exists add a record to project_debts
                                     */
                                    $expenses = Report::getReportsCostByProjectAndDates($currentMilestone->project_id, $dateFrom, $toDate);

                                    $query  = FinancialIncome::find();
                                    $query->where([
                                        'financial_report_id'   => $financialReport->id,
                                        'project_id'            => $currentMilestone->project_id
                                    ]);
                                    $query->select(['SUM(amount)']);
                                    $amount = $query->scalar();

                                    if ( $expenses > $amount ) {

                                        $pD = new ProjectDebt();
                                        $pD->project_id             = $currentMilestone->project_id;
                                        $pD->financial_report_id    = $nextFinRep->id;
                                        $pD->amount                 = ceil( $expenses - $amount);
                                        $pD->save();

                                    }
                                    $dateFrom   = $finReportRange->fromDate;
                                    $toDate     = $finReportRange->toDate;
                                    $currentMilestone = $milestone;

                                }
                                if ( strtotime( $milestone->start_date ) < $finReportRange->from ) {

                                    $dateFrom = $milestone->start_date;

                                }
                                if ( strtotime($milestone->closed_date) < $finReportRange->to ) {

                                    $toDate = $milestone->closed_date;

                                }


                            }

                        }

                    }
                    /**
                     * @see https://jira.skynix.co/browse/SCA-271
                     * For HOURLY Projects
                     * When a Financial Report is locked and during the period the project has debts -> add a record to project_debts
                     */
                    Yii::getLogger()->log('Checking hourly projects for debts', Logger::LEVEL_INFO);
                    $allProjects = Project::find()
                        ->where([
                            'is_delete' => 0,
                            'status'    => Project::STATUS_INPROGRESS,
                            'type'      => Project::TYPE_HOURLY
                        ])->all();
                    foreach ( $allProjects as $project ) {

                        $dateFrom           = $finReportRange->fromDate;
                        $toDate             = $finReportRange->toDate;

                        if ( $project->type === Project::TYPE_FIXED_PRICE ) {

                            $milestonesList = Milestone::find()
                                ->where([
                                    'project_id'    => $project->id,
                                    'status'        => Milestone::STATUS_CLOSED
                                ])
                                ->andWhere(['between', 'closed_date', $finReportRange->fromDate, $finReportRange->toDate])
                                ->all();

                            $milestones = ArrayHelper::toArray($milestonesList, [
                                'app\models\Milestone' => [
                                    'id',
                                    'name',
                                    'start_date',
                                    'end_date',
                                    'closed_date'
                                ],
                            ]);

                            foreach ( $milestones as $milestone ) {

                                if ( strtotime( $milestone['start_date'] ) < $finReportRange->from ) {

                                    $dateFrom = $milestone['start_date'];

                                }
                                if ( strtotime($milestone['closed_date']) < $finReportRange->to ) {

                                    $toDate = $milestone['closed_date'];

                                }

                            }

                        }

                        $expenses = Report::getReportsCostByProjectAndDates($project->id, $dateFrom, $toDate);

                        $query  = FinancialIncome::find();
                        $query->where([
                            'financial_report_id'   => $financialReport->id,
                            'project_id'            => $project->id
                        ]);
                        $query->select(['SUM(amount)']);
                        $amount = $query->scalar();

                        if ( $expenses > $amount ) {

                            $pD = new ProjectDebt();
                            $pD->project_id             = $project->id;
                            $pD->financial_report_id    = $nextFinRep->id;
                            $pD->amount                 = ceil( $expenses - $amount);
                            $pD->save();

                        }

                    }
                    
                    /**
                     * @see https://jira.skynix.co/browse/SCA-324
                     * 4 Implement vacation calculations into a Locking Financial Report
                     */
                    Yii::getLogger()->log('Vacation calculations', Logger::LEVEL_INFO); 
                    if ($salaryReport) {
                        $users = User::find()
                            ->where(['role'=>
                                [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_PM],
                                'is_active' => 1,
                                'is_delete' => 0
                            ])
                            ->orderBy(['id'   => 'ASC'])
                            ->all();
                        if ($users) {
                            foreach ( $users as $user ) {                  
                                $salaryReportList = SalaryReportList::find()
                                    ->where(['salary_report_id' => $salaryReport->id])
                                    ->andWhere(['user_id' => $user->id])
                                    ->one();
                                if ($salaryReportList) {
                                    $user->vacation_days_available = $user->vacation_days_available - $salaryReportList->vacation_days;                                 
                                    if ($salaryReportList->vacation_days > 0) {
                                        $vacationhistoryItem = new VacationHistoryItem();
                                        $vacationhistoryItem->user_id = $user->id;
                                        $vacationhistoryItem->days = $salaryReportList->vacation_days;
                                        $vacationhistoryItem->date = $financialReport->report_date;
                                        $vacationhistoryItem->save(false);
                                    }
                                    $vacationDaysUpgradeYears = Setting::find()
                                        ->where(['key' => 'vacation_days_upgrade_years'])
                                        ->one();
                                    $vacationDaysUpgraded = Setting::find()
                                        ->where(['key' => 'vacation_days_upgraded'])
                                        ->one();
                                    if ((date('n', strtotime($financialReport->report_date)))=='12'){
                                        if (((date("Y") - date('Y', strtotime($user->date_signup)))  >= $vacationDaysUpgradeYears->value) &&
                                            ($user->vacation_days !== $vacationDaysUpgraded->value)) {
                                                $user->vacation_days = $vacationDaysUpgraded->value;
                                        }
                                        $user->vacation_days_available = $user->vacation_days_available + $user->vacation_days;
                                    }                                   
                                    $user->save();
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
                    $user->save(false, ['salary', 'date_salary_up']);

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