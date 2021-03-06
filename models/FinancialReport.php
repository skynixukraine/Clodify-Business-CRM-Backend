<?php

namespace app\models;

use app\components\DateUtil;
use Yii;
use yii\log\Logger;

/**
 * This is the model class for table "financial_reports".
 *
 * @property integer $id
 * @property integer $report_date
 * @property double $currency
 * @property string $expense_constant
 * @property double $expense_salary
 * @property string $investments
 * @property integer $num_of_working_days
 */
class FinancialReport extends \yii\db\ActiveRecord
{
    const NOT_LOCKED = 0;
    const LOCKED = 1;

    const NUM_OF_WORKING_DAY_MIN = 15;
    const NUM_OF_WORKING_DAY_MAX = 31;

    const SCENARIO_FINANCIAL_REPORT_CREATE = 'api-financial_report-create';
    const SCENARIO_FINANCIAL_REPORT_UPDATE = 'api-financial_report-update';

    public $report_year;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'financial_reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_date'], 'date', 'message' => '{attribute}: is not a date!', 'format' => 'yyyy-MM-dd',
                'on' => [self::SCENARIO_FINANCIAL_REPORT_CREATE]],
            [['report_date'], 'required',
                'on' => [self::SCENARIO_FINANCIAL_REPORT_CREATE]],
            [['expense_constant', 'investments', 'spent_corp_events'], 'string',
                'on' => self::SCENARIO_FINANCIAL_REPORT_UPDATE],
            [['currency', 'expense_salary', 'is_locked'], 'number',
                'on' => self::SCENARIO_FINANCIAL_REPORT_UPDATE],
            ['num_of_working_days', 'integer',
                'min' => self::NUM_OF_WORKING_DAY_MIN, 'max' => self::NUM_OF_WORKING_DAY_MAX,
                'on' => self::SCENARIO_FINANCIAL_REPORT_UPDATE],
            ['report_year', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_date' => 'Report Date',
            'currency' => 'Currency',
            'expense_constant' => 'Expense Constant',
            'expense_salary' => 'Expense Salary',
            'investments' => 'Investments',
            'spend_corp_events' => 'Spend Corp Events',
            'num_of_working_days' => 'Num',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancialIncome()
    {
        return $this->hasMany(FinancialIncome::className(), ['financial_report_id' => 'id']);
    }

    /**
     * income = sum of all income amounts
     * @param $id
     * @param $userId
     * @return int
     */
    public static function sumIncome($id, $userId = null)
    {
        /** @var  $financialReport $this */
        $financialReport = FinancialReport::findOne($id);
        $incomeQuery = $financialReport->getFinancialIncome();
        if ( $userId > 0 ) {

            $incomeQuery->where(['added_by_user_id' => $userId]);

        }
        $incomeItems   = $incomeQuery->all();
        $incomeSum = 0;

        if ($financialReport && $incomeItems) {
            /** @var  $income FinancialIncome */
            foreach ($incomeItems as $income) {
                $incomeSum += (float)$income->amount;
            }
        }

        return round($incomeSum, 2);
    }

    /**
     * sum of all expense constant amounts
     * @param $id
     * @return int
     */
    public static function sumExpenseConstant($id)
    {
        $financialReport = FinancialReport::findOne($id);
        $financialReport = json_decode($financialReport->expense_constant);
        $expenseConstantSum = 0;

        if ($financialReport) {
            foreach ($financialReport as $exp_con) {
                $expenseConstantSum += (int)$exp_con->amount;
            }
        }

        return $expenseConstantSum;
    }

    /**
     * @param $id
     * @param $userSalesId
     * @return int|mixed
     */
    public static function sumDeveloperExpenses($id, $userSalesId)
    {
        $financialReport = FinancialReport::findOne($id);

        $projectsDeveloper = ProjectDeveloper::getReportsOfSales( $userSalesId );
        $projectIds = [];
        foreach($projectsDeveloper as $project){

            $projectIds[] = $project->project_id;

        }
        $projectIds = $projectIds ? implode(', ', $projectIds) : 0;

        $finReportRange = DateUtil::getUnixMonthDateRangesByDate($financialReport->report_date);
        $expenses = Report::find()
            ->where(Report::tableName() . '.project_id IN (' . $projectIds . ') ')
            ->andWhere(['between', 'date_report', $finReportRange->from, $finReportRange->to ])
            ->sum('cost');

        return $expenses > 0 ? $expenses : 0;
    }

    /**
     * sum of all expense salary amounts
     * @param $id
     * @return float
     */
    public static function getExpenseSalary($id)
    {
        $financialReport = FinancialReport::findOne($id);
        return $financialReport->expense_salary;
    }

    /**
     * sum of all investments amount
     * @param $id
     * @return int
     */
    public static function sumInvestments($id)
    {
        $financialReport = FinancialReport::findOne($id);
        $financialReport = json_decode($financialReport->investments);
        $investmentsSum = 0;

        if ($financialReport) {
            foreach ($financialReport as $investment) {
                $investmentsSum += (int)$investment->amount;
            }
        }

        return $investmentsSum;
    }

    /**
     *expenses = sum of all exp.ense_constant amounts + expense_salary
     * @param $id
     * @return float
     */
    public static function sumExpenses($id)
    {
        return self::cutDecimal(self::getExpenseSalary($id) + self::sumExpenseConstant($id));
    }

    /**
     * profit = income - expenses
     * @param $id
     * @return int
     */
    public static function getProfit($id)
    {
        return self::cutDecimal(self::sumIncome($id) - self::sumExpenses($id));
    }

    /**
     * balance = profit - sum of all investments amounts
     * @param $id
     * @return int
     */
    public static function getBalance($id)
    {
        return self::cutDecimal(self::getProfit($id) - self::sumInvestments($id));
    }

    /**
     *Make a float only show two decimal places exept case 99.999999999
     * @param $decimal
     * @return float
     */
    public static function cutDecimal($decimal)
    {
        return round($decimal, 2);
    }

    /**
     * Validate:
     *     only one report per month can be created.
     *
     * @param $reportDate
     * @return bool
     */
    public static function validateReportDate($date)
    {

        $financialReport = FinancialReport::find()->where( 'YEAR(`report_date`) = :year AND MONTH(`report_date`) = :month',
            [':year' => date('Y', strtotime( $date )), ':month' => date('m', strtotime( $date ))])->one();

        if ($financialReport) {
                return false;
        }

        return true;
    }

    /**
     * Get sum spent_corp_events
     *
     * @param $id
     * @return int
     */
    public static function sumSpentCorpEvents($id)
    {
        $financialReport = FinancialReport::findOne($id);
        $financialReport = json_decode($financialReport->spent_corp_events);
        $spent_corp_eventsSum = 0;

        if ($financialReport) {
            foreach ($financialReport as $sp_corp_eve) {
                $spent_corp_eventsSum += (int)$sp_corp_eve->amount;
            }
        }

        return $spent_corp_eventsSum;
    }

    /**
     *  Check that a financial report for this month exists and columns financial_reports→num_of_working_days  > 0
     * @param $id
     * @return bool
     */
    public static function validateReportForSalaryList($date)
    {
        $yearMonth = DateUtil::getMonthYearByDate($date);
        if ( ( $financialReport = self::find()
            ->where(['between', 'report_date', $yearMonth . '-01', $yearMonth . '-31' ])
            ->one() ) &&
            $financialReport->num_of_working_days > 0 && $financialReport->currency > 0 ) {

            return true;

        }
        return false;
    }

    /**
     *  Check that financial_reports→currency for this month > 0
     * @param $id
     * @return mixed
     */

    public static function getCurrency($date)
    {
        $yearMonth = DateUtil::getMonthYearByDate($date);
        if ( ( $financialReport = self::find()
            ->where(['between', 'report_date', $yearMonth . '-01', $yearMonth . '-31' ])
            ->one() ) ) {

            return $financialReport->currency;

        }
    }

    /**
     *  get financial_reports→num_of_working_days
     * @param $id
     * @return mixed
     */
    public static function getNumOfWorkingDays($date)
    {
        $yearMonth = DateUtil::getMonthYearByDate($date);
        if ( ( $financialReport = self::find()
            ->where(['between', 'report_date', $yearMonth . '-01', $yearMonth . '-31' ])
            ->one() ) ) {

            return $financialReport->num_of_working_days;

        }
    }

    /**
     *  Check that if only a financial report is not locked
     * @param $id
     * @return mixed
     */

    public static function isLock($date)
    {
        $yearMonth = DateUtil::getMonthYearByDate($date);
        return self::find()
            ->where(['between', 'report_date', $yearMonth . '-01', $yearMonth . '-31' ])
            ->andWhere(['is_locked' => 1])
            ->one() ? true : false;
    }
}
