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
 * @property integer $non_approved_hours
 * @property double $overtime_value
 * @property double $other_surcharges
 * @property double $subtotal
 * @property double $currency_rate
 * @property double $subtotal_uah
 * @property double $total_to_pay
 * @property integer $approved_hours
 * @property integer $worked_hours
 * @property integer $vacation_days
 * @property double $vacation_value
 * @property SalaryReport $salaryReport
 * @property User $user
 */
class SalaryReportList extends \yii\db\ActiveRecord
{
    const SCENARIO_SALARY_REPORT_LISTS_CREATE = 'api-salary_report-lists_create';
    const SCENARIO_SALARY_REPORT_LISTS_UPDATE = 'api-salary_report-lists_update';

    public $worked_hours;
    public $approved_hours;

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
            [['salary_report_id', 'user_id', 'worked_days', 'hospital_days', 'day_off', 'vacation_days', 'overtime_days'],'integer',
                'on' => [self::SCENARIO_SALARY_REPORT_LISTS_CREATE]],
            [[
                'bonuses',
                'other_surcharges',
                'actually_worked_out_salary',
                'overtime_value',
                'currency_rate',
                'subtotal_uah',
                'total_to_pay',
                'official_salary',
                'hospital_value',
                'vacation_value',
                'subtotal'
            ],'double',
                'on' => [self::SCENARIO_SALARY_REPORT_LISTS_CREATE]
            ],
            [['salary_report_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalaryReport::className(), 'targetAttribute' => ['salary_report_id' => 'id'],'on' => [self::SCENARIO_SALARY_REPORT_LISTS_CREATE]],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id'], 'on' => [self::SCENARIO_SALARY_REPORT_LISTS_CREATE]],
            [['worked_days', 'hospital_days', 'vacation_days', 'day_off', 'overtime_days'], 'integer', 'on' => [self::SCENARIO_SALARY_REPORT_LISTS_UPDATE]],
            [['official_salary', 'hospital_value', 'bonuses', 'actually_worked_out_salary', 'overtime_value', 'other_surcharges', 'subtotal', 'currency_rate', 'vacation_value', 'subtotal_uah', 'total_to_pay'], 'double',
                'on' => [self::SCENARIO_SALARY_REPORT_LISTS_UPDATE]],
            [['worked_hours', 'approved_hours', 'non_approved_hours'], 'integer'],
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
            'subtotal_uah'  => 'Subtotal Uah',
            'total_to_pay'  => 'Total To Pay',
            'worked_hours'  => 'Worked Hours',
            'approved_hours'    => 'Approved Hours',
            'vacation_days'     => 'Vacation Days',
            'vacation_value'    => 'Vacation Value',

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

    /**
     * @param SalaryReportList $salaryListReport
     * @param $workingDays
     * @return float|null
     */
    public static function getHospitalValue(SalaryReportList $salaryListReport, $workingDays)
    {
        $result = null;
        if ($workingDays) {
            $result = ($salaryListReport->salary / $workingDays) * $salaryListReport->hospital_days / 2;
        }
        return $result;
    }

    /**
     * @param SalaryReportList $salaryListReport
     * @param $workingDays
     * @return float|int|null
     */
    public static function getOvertimeValue(SalaryReportList $salaryListReport, $workingDays)
    {
        $result = null;
        if ($workingDays) {
            $result = ($salaryListReport->salary / $workingDays) * $salaryListReport->overtime_days * 1.5;
        }
        return $result;
    }

    public static function getHourlyRate(SalaryReportList $salaryListReport, $workingDays)
    {
        $result = 0;
        if ($workingDays > 0) {
            $result = round( ($salaryListReport->salary / $workingDays)  / 8 );
        }
        return $result;
    }

    /**
     * @param SalaryReportList $salaryListReport
     * @param $workingDays
     * @return float|int|null
     */
    public static function getActuallyWorkedOutSalary(SalaryReportList $salaryListReport, $workingDays)
    {
        $result = null;
        if ($workingDays) {
            $result = ($salaryListReport->salary / $workingDays) * $salaryListReport->worked_days;
        }
        return $result;
    }

    /**
     * @param SalaryReportList $salaryListReport
     * @param $workingDays
     * @return float|int|null
     */
    public static function getVacationValue(SalaryReportList $salaryListReport, $workingDays)
    {
        $result = null;
        if ($workingDays) {
            $result = $salaryListReport->vacation_days * ($salaryListReport->salary / $workingDays);
        }
        return $result;
    }

    /**
     * @param $salaryListReport
     * @return mixed
     */
    public static function getSubtotal(SalaryReportList $salaryListReport)
    {
        return $salaryListReport->actually_worked_out_salary + $salaryListReport->hospital_value +
            $salaryListReport->bonuses + $salaryListReport->overtime_value + $salaryListReport->other_surcharges
            + $salaryListReport->vacation_value;
    }

    /**
     * @param $salaryListReport
     * @return mixed
     */
    public static function getSubtotalUah($salaryListReport)
    {
        return $salaryListReport->subtotal * $salaryListReport->currency_rate;
    }

    /**
     * @param $salaryListReport
     * @return mixed
     */
    public static function getTotalToPay($salaryListReport)
    {
        return $salaryListReport->subtotal_uah - $salaryListReport->official_salary;
    }

    /**
     * @param $salaryReportLists
     * @param $attr
     * @return int
     */
    public static function getSumOf($salaryReportLists, $attr)
    {
        $total = 0;
        foreach ($salaryReportLists as $salaryReportList) {
            $total += $salaryReportList->$attr;
        }
        return $total;
    }

    /**
     * @param $salaryReportLists
     * @param $attr
     * @return int
     */
    public static function getSumByCurrency($salaryReportLists, $attr)
    {
        $total = 0;
        foreach ($salaryReportLists as $salaryReportList) {
            $total += $salaryReportList->$attr * $salaryReportList->currency_rate;
        }
        return $total;
    }

    /**
     * FOPs Salaries in UAH
     * @param $salaryReportLists
     * @return float|int
     */
    public static function getSumOfSalariesOfFOPs($salaryReportLists)
    {
        $total = 0;
        /** @var  $salaryReportList SalaryReportList */
        foreach ($salaryReportLists as $salaryReportList) {
            if ( $salaryReportList->official_salary > 0 && $salaryReportList->official_salary < 0.05 ) {

                $total += $salaryReportList->total_to_pay;

            }
        }
        return $total;
    }

    /**
     * @param $salaryReportId
     * @param $userId
     * @return bool
     */
    public static function checkOneUserPerMonth($salaryReportId, $userId)
    {
        $salaryReportLists = SalaryReportList::find()->all();
        foreach ($salaryReportLists as $salaryReportList) {
            if ($salaryReportList->salary_report_id == $salaryReportId &&
                $salaryReportList->user_id == $userId) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $userId
     * @param $date
     * @return int
     * take month and year from exp: '1389916800'
     * and return number of working days (Monday - Friday) with more than 6 reported hours
     */
    public static function numWorkedDaysInMonth($userId, $date)
    {
        $m = date('m', $date);
        $y = date('Y', $date);
        $lastday = date("t",mktime(0,0,0,$m,1,$y));
        $workdays=0;
        for($d=1;$d<=$lastday;$d++) {
            $wd = date("w",mktime(0,0,0,$m,$d,$y));
            if($wd > 0 && $wd < 6) {
                if (self::sumHoursReportsForMonth($userId, date('Y-m-d',mktime(0,0,0,$m,$d,$y))) >= 6) {
                    $workdays++;
                }
            }
        }
        return $workdays;
    }

    /**
     * Calculate a sum of non approved hours per day → SNAH
        If ReportedHours >= 6 then SNAH = 6 - ApprovedHours;
        If ReportedHours < 6 then SNAH = 0;
        If SNAH < 0 then SNAH=0;
     * @param $userId
     * @param $date
     * @return int|mixed
     */
    public static function getNumNonApprovedHoursInMonthDuringWorkingDays($userId, $date)
    {
        $m = date('m', $date);
        $y = date('Y', $date);
        $lastday    = date("t",mktime(0,0,0,$m,1,$y));
        $hours      = 0;
        for($d=1;$d<=$lastday;$d++) {
            $wd = date("w",mktime(0,0,0,$m,$d,$y));
            if($wd > 0 && $wd < 6) {
                $datePointer = date('Y-m-d',mktime(0,0,0,$m,$d,$y));
                if ( ($reportedHours = Report::sumHoursReportsOfThisDay($userId, $datePointer) ) >= 6 &&
                    ($h = self::sumApprovedHoursReportsForDay($userId, $datePointer)) &&
                    (6 - $h) > 0 ) {

                    $hours += (6 - $h);
                }
            }
        }
        return round($hours);
    }

    /**
     * @param $userId
     * @param $dateReport
     * @return mixed
     * require 'Y-m-d' format of date
     */
    public static function sumHoursReportsForMonth($userId, $dateReport)
    {
        return Report::find()
            ->andWhere(['user_id'       => $userId])
            ->andWhere(['date_report'   => $dateReport])
            ->andWhere(['is_delete'     => Report::ACTIVE])
            ->sum(Report::tableName() . '.hours');
    }

    /**
     * @param $userId
     * @param $dateReport
     * @return mixed
     */
    public static function sumApprovedHoursReportsForDay($userId, $dateReport)
    {
        return Report::find()
            ->andWhere(['user_id'       => $userId])
            ->andWhere(['date_report'   => $dateReport])
            ->andWhere(['is_approved'   => 1])
            ->andWhere(['is_delete'     => Report::ACTIVE])
            ->sum(Report::tableName() . '.hours');
    }

    /**
     * @param $userId
     * @param $date
     * @param $numWorkDays
     * @return int
     */
    public static function getNumOfWorkedDays($userId, $date, $numWorkDays)
    {
        $workDays = self::numWorkedDaysInMonth($userId, $date);
       return $workDays <= $numWorkDays ? $workDays : $numWorkDays;
    }

    /**
     * @param $salRepList
     * @return mixed
     */
    public static function sumReportedHoursForMonthPerUser($salRepList)
    {

        $dateFrom = date('Y-m-01', $salRepList->salaryReport->report_date);
        $toDate     = date('Y-m-t', $salRepList->salaryReport->report_date);

        $sum = Report::find()
            ->andWhere(['user_id' => $salRepList->user_id])
            ->andWhere(['is_delete' => Report::ACTIVE])
            ->andWhere(['between', 'date_report', $dateFrom, $toDate])
            ->sum(Report::tableName() . '.hours');
        return $sum ? ceil($sum) : 0;
    }

    /**
     * @param $salRepList
     * @return mixed
     */
    public static function sumApprovedHoursForMonthPerUser($salRepList)
    {

        $dateFrom = date('Y-m-01', $salRepList->salaryReport->report_date);
        $toDate     = date('Y-m-t', $salRepList->salaryReport->report_date);

        $sum = Report::find()
            ->andWhere(['user_id' => $salRepList->user_id])
            ->andWhere(['is_delete' => Report::ACTIVE])
            ->andWhere(['is_approved' => Report::APPROVED])
            ->andWhere(['between', 'date_report', $dateFrom, $toDate])
            ->sum(Report::tableName() . '.hours');
        return $sum ? ceil($sum) : 0;
    }

}
