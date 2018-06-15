<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 25.08.17
 * Time: 15:35
 */
namespace viewModel;

use app\models\WorkHistory;
use Yii;
use app\models\FinancialReport;
use app\models\SalaryReportList;
use app\models\SalaryReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
/**
 * Class SalaryListCreate
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-6
 * @author  Igor Luchko (Skynix)
 */
class SalaryListCreate extends ViewModelAbstract
{
    private $working_days;

    public function define()
    {
        // TODO: Implement define() method.
        $user = User::findOne($this->model->user_id);

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {

            $salaryReportId = Yii::$app->request->getQueryParam('id');

            $salaryReport = SalaryReport::findOne($salaryReportId);
            if (User::isActiveUser($user->id)) {
                if (FinancialReport::validateReportForSalaryList($salaryReport->report_date)) {
                    if (User::validateRoleForSalaryList($user->id)) {
                        if (User::validateSalaryForSalaryList($user->id)) {
                            if (!FinancialReport::isLock($salaryReport->report_date)) {
                                if (SalaryReportList::checkOneUserPerMonth($salaryReportId, $user->id)) {

                                    $this->working_days = FinancialReport::getNumOfWorkingDays($salaryReport->report_date);

                                    $this->model->salary            = $user->salary;
                                    $this->model->salary_report_id  = $salaryReportId;
                                    $this->model->worked_days       = SalaryReportList::getNumOfWorkedDays($user->id, $salaryReport->report_date, $this->working_days);
                                    $this->model->currency_rate     = FinancialReport::getCurrency($salaryReport->report_date);
                                    $this->model->actually_worked_out_salary = SalaryReportList::getActuallyWorkedOutSalary($this->model, $this->working_days);
                                    $this->model->official_salary   = $user->official_salary;
                                    $this->model->hospital_value    = SalaryReportList::getHospitalValue($this->model, $this->working_days);
                                    $this->model->vacation_value    = SalaryReportList::getVacationValue($this->model, $this->working_days);
                                    $this->model->day_off           = $this->working_days + $this->model->vacation_days -  $this->model->worked_days;
                                    $this->model->overtime_value    = SalaryReportList::getOvertimeValue($this->model, $this->working_days);
                                    $this->model->subtotal          = SalaryReportList::getSubtotal($this->model);
                                    $this->model->subtotal_uah      = SalaryReportList::getSubtotalUah($this->model);
                                    $this->model->total_to_pay      = SalaryReportList::getTotalToPay($this->model);

                                    if ($this->validate() && $this->model->save()) {

                                        if ( $this->model->day_off > 0 ) {

                                            WorkHistory::create(
                                                WorkHistory::TYPE_USER_FAILS,
                                                $user->id,
                                                \Yii::t('app', '- Did not work {num} days', [
                                                    'num' => $this->model->day_off
                                                ])
                                            );

                                        }

                                        $this->setData([
                                            'list_id' => $this->model->id
                                        ]);
                                    }
                                } else {
                                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Only one list per month per user can be created'));
                                }
                            } else {
                                return $this->addError(Processor::ID_PARAM, Yii::t('yii', ' Sorry, The financial report is locked'));
                            }
                        } else {
                            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', ' Please specify a salary & official salary for a passed user before creating a salary list.'));
                        }

                    } else {
                        return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Sorry, but you can create a list report for  DEV, SALES and FIN employees only'));
                    }

                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Please create a financial report first and fill in the number of working days and currency rate proper values.'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Sorry, you can not create a salary list for a blocked user.'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

}