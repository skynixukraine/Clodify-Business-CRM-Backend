<?php

/**
 * Created by Skynix Team.
 * User: igor
 * Date: 29.08.17
 * Time: 10:18
 */

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
<<<<<<< HEAD
 *
 * @property SalaryReports $salaryReport
 * @property Users $user
 */
class SalaryReportList extends \yii\db\ActiveRecord
{
    const SCENARIO_SALARY_REPORT_LISTS_CREATE = 'api-salary_report-lists_create';
    const SCENARIO_SALARY_REPORT_LISTS_UPDATE = 'api-salary_report-lists_update';

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

            [['salary_report_id', 'user_id', 'worked_days', 'hospital_days', 'bonuses', 'day_off', 'overtime_days', 'other_surcharges'], 'required',
                'on' => [self::SCENARIO_SALARY_REPORT_LISTS_CREATE]],
            [['salary_report_id', 'user_id', 'worked_days', 'hospital_days', 'day_off', 'overtime_days'],'integer',
                'on' => [self::SCENARIO_SALARY_REPORT_LISTS_CREATE]],
            [['bonuses', 'other_surcharges', 'actually_worked_out_salary', 'overtime_value', 'currency_rate', 'subtotal_uah', 'total_to_pay', 'official_salary', 'hospital_value', 'subtotal'],'double',
                'on' => [self::SCENARIO_SALARY_REPORT_LISTS_CREATE]],
            [['worked_days', 'hospital_days', 'bonuses', 'day_off', 'overtime_days', 'other_surcharges'], 'required',
                'on' => [self::SCENARIO_SALARY_REPORT_LISTS_UPDATE]],
            [['worked_days', 'hospital_days', 'day_off', 'overtime_days'], 'integer', 'on' => [self::SCENARIO_SALARY_REPORT_LISTS_UPDATE]],
            [['official_salary', 'hospital_value', 'bonuses', 'actually_worked_out_salary', 'overtime_value', 'other_surcharges', 'subtotal', 'currency_rate', 'subtotal_uah', 'total_to_pay'], 'double',
                'on' => [self::SCENARIO_SALARY_REPORT_LISTS_UPDATE]],
            [['salary_report_id', 'user_id', 'salary', 'worked_days', 'actually_worked_out_salary', 'hospital_days', 'day_off', 'overtime_days'], 'integer'],
            [['official_salary', 'hospital_value', 'bonuses', 'overtime_value', 'other_surcharges', 'subtotal', 'currency_rate', 'subtotal_uah', 'total_to_pay'], 'number'],
            [['salary_report_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryReport::className(), 'targetAttribute' => ['salary_report_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalaryReport()
    {
        return $this->hasOne(SalaryReport::className(), ['id' => 'salary_report_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
