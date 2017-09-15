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
            [['year'], 'integer'],
            [['income', 'expense_constant', 'investments', 'expense_salary', 'difference', 'bonuses', 'corp_events', 'profit', 'balance', 'spent_corp_events'], 'double'],
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

    /**
     * difference = income - expense_constant
     * @param $id
     * @return int
     */
    public static function getDifference($id)
    {
        return FinancialReport::sumIncome($id) - FinancialReport::sumExpenseConstant($id);
    }

    /**
     *  bonuses = 10% of difference
     * @param $id
     * @return int
     */
    public static function getBonuses($id)
    {
        return self::getDifference($id) * 0.1;
    }

    /**
     * corp_events = 10% of difference
     * @param $id
     * @return int
     */
    public static function getCorpEvents($id)
    {
        return self::getDifference($id) * 0.1;
    }

    /**
     * profit = difference - bonuses - corp_events
     * @param $id
     * @return int
     */
    public static function getYearlyProfit($id)
    {
        return self::getDifference($id) - self::getBonuses($id) - self::getCorpEvents($id);
    }

    /**
     * @param $year
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findYearlyReport($year)
    {
        return FinancialYearlyReport::find()->where('year = :xy', [':xy' => $year])->one();
    }

}
