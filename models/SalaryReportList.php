<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_report_lists".
 *
 * @property integer $id
 * @property integer $salary_report_id
 * @property integer $user_id
 * @property integer $salary
 * @property integer $worked_days
 * @property integer $actually_worked_out_salary
 * @property double $official_salary
 * @property integer $hospital_days
 * @property double $hospital_value
 * @property double $bonuses
 * @property integer $day_off
 * @property integer $overtime_days
 * @property double $overtime_value
 * @property double $other_surcharges
 * @property double $subtotal
 * @property double $currency_rate
 * @property double $subtotal_uah
 * @property double $total_to_pay
 */
class SalaryReportList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_report_lists';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salary_report_id', 'user_id', 'salary', 'worked_days', 'actually_worked_out_salary', 'hospital_days', 'day_off', 'overtime_days'], 'integer'],
            [['official_salary', 'hospital_value', 'bonuses', 'overtime_value', 'other_surcharges', 'subtotal', 'currency_rate', 'subtotal_uah', 'total_to_pay'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salary_report_id' => 'Salary Report ID',
            'user_id' => 'User ID',
            'salary' => 'Salary',
            'worked_days' => 'Worked Days',
            'actually_worked_out_salary' => 'Actually Worked Out Salary',
            'official_salary' => 'Official Salary',
            'hospital_days' => 'Hospital Days',
            'hospital_value' => 'Hospital Value',
            'bonuses' => 'Bonuses',
            'day_off' => 'Day Off',
            'overtime_days' => 'Overtime Days',
            'overtime_value' => 'Overtime Value',
            'other_surcharges' => 'Other Surcharges',
            'subtotal' => 'Subtotal',
            'currency_rate' => 'Currency Rate',
            'subtotal_uah' => 'Subtotal Uah',
            'total_to_pay' => 'Total To Pay',
        ];
    }
}
