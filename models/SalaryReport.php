<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 23.08.17
 * Time: 12:50
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "salary_reports".
 *
 * @property integer $id
 * @property integer $report_date
 * @property double $total_salary
 * @property double $official_salary
 * @property double $bonuses
 * @property double $hospital
 * @property double $day_off
 * @property double $overtime
 * @property double $other_surcharges
 * @property double $subtotal
 * @property double $currency_rate
 * @property double $total_to_pay
 * @property integer $number_of_working_days
 */
class SalaryReport extends \yii\db\ActiveRecord
{
    const SCENARIO_SALARY_REPORT_CREATE = 'api-salary_report-create';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary_reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_date'], 'integer',
                'on' => [self::SCENARIO_SALARY_REPORT_CREATE]],
            [['report_date'], 'required',
                'on' => [self::SCENARIO_SALARY_REPORT_CREATE]],
            [['number_of_working_days'], 'integer'],
            [['total_salary', 'official_salary', 'bonuses', 'hospital', 'day_off', 'overtime', 'other_surcharges', 'subtotal', 'currency_rate', 'total_to_pay'], 'number'],
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
            'total_salary' => 'Total Salary',
            'official_salary' => 'Oficial Salary',
            'bonuses' => 'Bonuses',
            'hospital' => 'Hospital',
            'day_off' => 'Day Off',
            'overtime' => 'Overtime',
            'other_surcharges' => 'Other Surcharges',
            'subtotal' => 'Subtotal',
            'currency_rate' => 'Currency Rate',
            'total_to_pay' => 'Total To Pay',
            'number_of_working_days' => 'Number Of Working Days',
        ];
    }

    /**
     * Validate:
     *     only one report per month can be created.
     *
     * @param $reportDate
     * @return bool
     */
    public static function validateSalaryReportDate($date)
    {

        $financialReports = SalaryReport::find()->all();

        foreach ($financialReports as $financialReport) {
            if (date('Y-m', $financialReport->report_date) == date('Y-m', $date)) {
                return false;
            }
        }

        return true;
    }
}
