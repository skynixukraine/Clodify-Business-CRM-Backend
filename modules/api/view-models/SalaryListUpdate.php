<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 29.08.17
 * Time: 10:23
 */

namespace viewModel;

use app\models\FinancialReport;
use app\models\SalaryReport;
use app\models\SalaryReportList;
use app\models\User;
use app\modules\api\components\Api\Processor;
use yii;

/**
 * Class SalaryListUpdate
 * @package viewModel
 */
class SalaryListUpdate extends ViewModelAbstract
{

    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
            if ($this->validate()) {
                $salaryReportId = Yii::$app->request->getQueryParam('sal_report_id');
                $salaryReportListId = Yii::$app->request->getQueryParam('id');

                $salaryListReport = SalaryReportList::findOne($salaryReportListId);
                $salaryReport = SalaryReport::findOne($salaryReportId);
                if ($salaryListReport) {
                    if (!FinancialReport::isLock($salaryReport->report_date)) {

                        $working_days = FinancialReport::getNumOfWorkingDays($salaryReport->report_date);
                        $user = User::findOne($salaryListReport->user_id);

                        $this->model->setScenario(SalaryReportList::SCENARIO_SALARY_REPORT_LISTS_UPDATE);
                        $salaryListReport->setScenario(SalaryReportList::SCENARIO_SALARY_REPORT_LISTS_UPDATE);

                        $salaryListReport->setAttributes(
                            array_intersect_key($this->postData, array_flip($this->model->safeAttributes())), false
                        );
                        $salaryListReport->worked_days      = SalaryReportList::getNumOfWorkedDays($user->id, $salaryReport->report_date, $working_days);
                        $salaryListReport->vacation_value   = SalaryReportList::getVacationValue($salaryListReport, $working_days);
                        $salaryListReport->non_approved_hours= SalaryReportList::getNumNonApprovedHoursInMonthDuringWorkingDays($user->id, $salaryReport->report_date);

                        $salaryListReport->day_off      =  $working_days - $salaryListReport->vacation_days - $salaryListReport->worked_days;
                        $salaryListReport->salary       = $user->salary;
                        $salaryListReport->currency_rate = FinancialReport::getCurrency($salaryReport->report_date);
                        $salaryListReport->actually_worked_out_salary = SalaryReportList::getActuallyWorkedOutSalary($salaryListReport, $working_days);
                        $salaryListReport->official_salary = $user->official_salary;
                        $salaryListReport->hospital_value = SalaryReportList::getHospitalValue($salaryListReport, $working_days);
                        $salaryListReport->overtime_value = SalaryReportList::getOvertimeValue($salaryListReport, $working_days);

                        if ( $user->pay_only_approved_hours === 1 && $this->model->non_approved_hours > 0 ) {

                            $hourlyRate = SalaryReportList::getHourlyRate($this->model, $working_days);
                            $salaryListReport->subtotal = ( $salaryListReport->subtotal - $hourlyRate * $salaryListReport->non_approved_hours);

                        }

                        $salaryListReport->subtotal = SalaryReportList::getSubtotal($salaryListReport);
                        $salaryListReport->subtotal_uah = SalaryReportList::getSubtotalUah($salaryListReport);
                        $salaryListReport->total_to_pay = SalaryReportList::getTotalToPay($salaryListReport);

                        if ($salaryListReport->validate()) {
                            $salaryListReport->save();
                        } else {
                            return $this->addError(Processor::ERROR_PARAM,
                                Yii::t('app', 'Sorry, but the entered data is not correct'));
                        }

                    } else {
                        return $this->addError(Processor::ERROR_PARAM,
                            Yii::t('app', 'Sorry, but this report period is locked. It is not editable'));
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM,
                        Yii::t('app', 'This salary list not exist. It is not editable'));
                }
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM,
                Yii::t('app', 'You have no permission for this action'));
        }
    }

}