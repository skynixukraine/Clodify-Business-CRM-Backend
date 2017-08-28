<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financial_reports".
 *
 * @property integer $id
 * @property integer $report_date
 * @property string $income
 * @property double $currency
 * @property string $expense_constant
 * @property double $expense_salary
 * @property string $investments
 */
class FinancialReport extends \yii\db\ActiveRecord
{
    const NOT_LOCKED = 0;
    const LOCKED = 1;

    const NUM_OF_WORKING_DAY_MIN = 15;
    const NUM_OF_WORKING_DAY_MAX = 31;

    const SCENARIO_FINANCIAL_REPORT_CREATE = 'api-financial_report-create';
    const SCENARIO_FINANCIAL_REPORT_UPDATE = 'api-financial_report-update';


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
            [['report_date'], 'integer',
                'on' => [self::SCENARIO_FINANCIAL_REPORT_CREATE, self::SCENARIO_FINANCIAL_REPORT_UPDATE]],
            [['report_date'], 'required',
                'on' => [self::SCENARIO_FINANCIAL_REPORT_CREATE, self::SCENARIO_FINANCIAL_REPORT_UPDATE]],
            [['income', 'expense_constant', 'investments', 'spent_corp_events'], 'string',
                'on' => self::SCENARIO_FINANCIAL_REPORT_UPDATE],
            [['currency', 'expense_salary', 'is_locked'], 'number',
                'on' => self::SCENARIO_FINANCIAL_REPORT_UPDATE],
            ['num_of_working_days', 'integer',
                'min' => self::NUM_OF_WORKING_DAY_MIN, 'max' => self::NUM_OF_WORKING_DAY_MAX,
                'on' => self::SCENARIO_FINANCIAL_REPORT_UPDATE]
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
            'income' => 'Income',
            'currency' => 'Currency',
            'expense_constant' => 'Expense Constant',
            'expense_salary' => 'Expense Salary',
            'investments' => 'Investments',
            'spend_corp_events' => 'Spend Corp Events'
        ];
    }

    /**
     * income = sum of all income amounts
     * @param $id
     * @return int
     */
    public static function sumIncome($id)
    {
        $financialReport = FinancialReport::findOne($id);
        $financialReport = json_decode($financialReport->income);
        $incomeSum = 0;

        if ($financialReport) {
            foreach ($financialReport as $income) {
                $incomeSum += $income->amount;
            }
        }

        return $incomeSum;
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
                $expenseConstantSum += $exp_con->amount;
            }
        }

        return $expenseConstantSum;
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
                $investmentsSum += $investment->amount;
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
        return self::getExpenseSalary($id) + self::sumExpenseConstant($id);
    }

    /**
     * profit = income - expenses
     * @param $id
     * @return int
     */
    public static function getProfit($id)
    {
        return self::sumIncome($id) - self::sumExpenses($id);
    }

    /**
     * balance = profit - sum of all investments amounts
     * @param $id
     * @return int
     */
    public static function getBalance($id)
    {
        return self::getProfit($id) - self::sumInvestments($id);
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

        $financialReports = FinancialReport::find()->all();

        foreach ($financialReports as $financialReport) {
            if (date('Y-m', $financialReport->report_date) == date('Y-m', $date)) {
                return false;
            }
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
                $spent_corp_eventsSum += $sp_corp_eve->amount;
            }
        }

        return $spent_corp_eventsSum;
    }

}