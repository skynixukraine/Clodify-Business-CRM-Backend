<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 23.08.17
 * Time: 12:50
 */

namespace app\models;

use app\components\DateUtil;
use Yii;

/**
 * This is the model class for table "salary_reports".
 *
 * @property integer $id
 * @property string $report_date
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

    public $report_year;
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
            [['report_date'], 'date', 'format' => 'php:Y-m-d',
                'on' => [self::SCENARIO_SALARY_REPORT_CREATE]],
            [['report_date'], 'required',
                'on' => [self::SCENARIO_SALARY_REPORT_CREATE]],
            [['number_of_working_days', 'total_employees'], 'integer'],
            [['report_year'], 'safe'],
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
            'total_employees' => 'Total Employees'
        ];
    }

    /**
     * Validate:
     * only one report per month can be created.
     *
     * @param $reportDate
     * @return bool
     */
    public static function validateSalaryReportDate($date)
    {

        return self::find()->where(['report_date' => $date])->one() ?
            false : true;
    }

    /**
     * @param $financialReport
     * @return mixed
     */
    public static function findSalaryReport($financialReport)
    {
        return self::find()
            ->where(['report_date' => date('Y-m-t', strtotime($financialReport->report_date))])
            ->one();
    }

    /**
     * @param $salRep
     * @return int|mixed
     */
    public static function getTotalReportedHours($salRep)
    {
        $sum = Report::find()
            ->andWhere(['is_delete' => Report::ACTIVE])
            ->andWhere(['like', 'date_added', DateUtil::getMonthYearByDate($salRep->report_date)])
            ->sum(Report::tableName() . '.hours');
        return $sum ? $sum : 0;
    }

    /**
     * @param $salRep
     * @return int|mixed
     */
    public static function getTotalApprovedHours($salRep)
    {

        $sum = Report::find()
            ->andWhere(['is_delete' => Report::ACTIVE])
            ->andWhere(['is_approved' => Report::APPROVED])
            ->andWhere(['like', 'date_added', DateUtil::getMonthYearByDate($salRep->report_date)])
            ->sum(Report::tableName() . '.hours');
        return $sum ? $sum : 0;
    }

}
