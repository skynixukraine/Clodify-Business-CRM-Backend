<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "financial_yearly_reports".
 *
 * @property integer $id
 * @property integer $year
 * @property integer $income
 * @property integer $expense_constant
 * @property integer $investments
 * @property integer $expense_salary
 * @property integer $difference
 * @property integer $bonuses
 * @property integer $corp_events
 * @property integer $profit
 * @property integer $balance
 * @property integer $spent_corp_events
 */
class FinancialYearlyReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'financial_yearly_reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'income', 'expense_constant', 'investments', 'expense_salary', 'difference', 'bonuses', 'corp_events', 'profit', 'balance', 'spent_corp_events'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'income' => 'Income',
            'expense_constant' => 'Expense Constant',
            'investments' => 'Investments',
            'expense_salary' => 'Expense Salary',
            'difference' => 'Difference',
            'bonuses' => 'Bonuses',
            'corp_events' => 'Corp Events',
            'profit' => 'Profit',
            'balance' => 'Balance',
            'spent_corp_events' => 'Spent Corp Events',
        ];
    }

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

    public static function getDifference($id)
    {
        return FinancialReport::sumIncome($id) - FinancialReport::sumExpenseConstant($id);
    }

    public static function getBonuses($id)
    {
        return self::getDifference($id) * 0.1;
    }

    public static function getCorpEvents($id)
    {
        return self::getDifference($id) * 0.1;
    }

    public static function getYearlyProfit($id)
    {
        return self::getDifference($id) - self::getBonuses($id) - self::getCorpEvents($id);
       // return self::getDifference($id) - self::getBonuses($id);
    }

    public static function isYearlyReportExist()
    {
        return self::find()
            ->where(FinancialYearlyReport::tableName() . '.year =:x',
                [':x' =>  date("Y"),])
            ->all();
    }

}
