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

    const EXPIRATION_PERIOD_CREATE = '30 days';

    const SCENARIO_FINANCIAL_REPORT_CREATE = 'api-financial_report-create';

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
            [['report_date'], 'integer', 'on' => self::SCENARIO_FINANCIAL_REPORT_CREATE],
            [['report_date'], 'required', 'on' => self::SCENARIO_FINANCIAL_REPORT_CREATE],
            [['income', 'expense_constant', 'investments'], 'string'],
            [['currency', 'expense_salary'], 'number'],
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
        ];
    }

    public static function sumIncome($id)
    {
        $income = 0;
        $financialReport = FinancialReport::findOne($id);
            foreach (json_decode($financialReport['income']) as $val) {
                foreach ($val as $k => $v) {
                    if ($k === 'amount') {
                        $income += $v;
                    }
                }
            }
            return $income;
    }

    public static function sumExpenseConstant($id)
    {
        $expcon = 0;
        $financialReport = FinancialReport::findOne($id);
        foreach (json_decode($financialReport['expense_constant']) as $val) {
            foreach ($val as $k => $v) {
                if ($k === 'amount') {
                    $expcon += $v;
                }
            }
        }
        return $expcon;
    }

    public static function sumExpenseSalary($id)
    {
        $financialReport = FinancialReport::findOne($id);
        return $financialReport->expense_salary;
    }

    public static function sumInvestments($id)
    {
        $inv = 0;
        $financialReport = FinancialReport::findOne($id);
        foreach (json_decode($financialReport['investments']) as $val) {
            foreach ($val as $k => $v) {
                if ($k === 'amount') {
                    $inv += $v;
                }
            }
        }
        return $inv;
    }

    public static function sumExpenses($id)
    {
        return self::sumExpenseSalary($id) + self::sumExpenseConstant($id);
    }

    public static function makeProfit($id)
    {
        return self::sumIncome($id) - self::sumExpenses($id);
    }

    public static function makeBalance($id)
    {
        return self::makeProfit($id) - self::sumInvestments($id);
    }

}
