<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 25.08.17
 * Time: 15:35
 */
namespace viewModel;

use Yii;
use app\models\FinancialReport;
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
            if (User::isActiveUser($user->id)) {
                if (FinancialReport::validateReportForSalaryList($this->model->salary_report_id)) {
                    if (User::validateRoleForSalaryList($user->id)) {
                        if (User::validateSalaryForSalaryList($user->id)) {
                            if (!FinancialReport::checkIsLockForSalaryList($this->model->salary_report_id)) {

                                $this->working_days = FinancialReport::getNumOfWorkingDaysForSalaryList($this->model->salary_report_id);

                                $this->model->salary = $user->salary;
                                $this->model->currency_rate = FinancialReport::getCurrencyForSalaryList($this->model->salary_report_id);
                                $this->model->actually_worked_out_salary = ($this->model->salary / $this->working_days) * $this->model->worked_days;
                                $this->model->official_salary = $user->official_salary;
                                $this->model->hospital_value = ($this->model->salary / $this->working_days) * $this->model->hospital_days / 2;
                                $this->model->overtime_value = ($this->model->salary / $this->working_days) * $this->model->overtime_days * 1.5;
                                $this->model->subtotal = $this->model->actually_worked_out_salary + $this->model->hospital_value +
                                    $this->model->bonuses + $this->model->overtime_value + $this->model->other_surcharges;
                                $this->model->subtotal_uah = $this->model->subtotal * $this->model->currency_rate;
                                $this->model->total_to_pay = $this->model->subtotal_uah - $this->model->official_salary;

                                if ($this->validate() && $this->model->save()) {

                                    $this->setData([
                                        'list_id' => $this->model->id
                                    ]);
                                }
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