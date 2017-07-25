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
            [['report_date'], 'integer', 'on' => [self::SCENARIO_FINANCIAL_REPORT_CREATE, self::SCENARIO_FINANCIAL_REPORT_UPDATE]],
            [['report_date'], 'required', 'on' => [self::SCENARIO_FINANCIAL_REPORT_CREATE, self::SCENARIO_FINANCIAL_REPORT_UPDATE]],
            [['income', 'expense_constant', 'investments'], 'string', 'on' => self::SCENARIO_FINANCIAL_REPORT_UPDATE],
            [['currency', 'expense_salary'], 'number', 'on' => self::SCENARIO_FINANCIAL_REPORT_UPDATE],
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
}
