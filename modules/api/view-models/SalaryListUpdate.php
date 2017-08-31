<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 29.08.17
 * Time: 10:23
 */

namespace viewModel;

use app\models\FinancialReport;
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
                if ($salaryListReport) {
                    if (!FinancialReport::checkIsLockForSalaryList($salaryReportId)) {

                        $working_days = FinancialReport::getNumOfWorkingDaysForSalaryList($salaryReportId);
                        $user = User::findOne($salaryListReport->user_id);

                        $salaryListReport->setAttributes(
                            array_intersect_key($this->postData, array_flip($this->model->safeAttributes())), false
                        );

                        $salaryListReport->salary = $user->salary;
                        $salaryListReport->currency_rate = FinancialReport::getCurrencyForSalaryList($salaryReportId);
                        $salaryListReport->actually_worked_out_salary = ($salaryListReport->salary / $working_days) * $salaryListReport->worked_days;
                        $salaryListReport->official_salary = $user->official_salary;
                        $salaryListReport->hospital_value = ($salaryListReport->salary / $working_days) * $salaryListReport->hospital_days / 2;
                        $salaryListReport->overtime_value = ($salaryListReport->salary / $working_days) * $salaryListReport->overtime_days * 1.5;
                        $salaryListReport->subtotal = $salaryListReport->actually_worked_out_salary + $salaryListReport->hospital_value +
                            $salaryListReport->bonuses + $salaryListReport->overtime_value + $salaryListReport->other_surcharges;
                        $salaryListReport->subtotal_uah = $salaryListReport->subtotal * $salaryListReport->currency_rate;
                        $salaryListReport->total_to_pay = $salaryListReport->subtotal_uah - $salaryListReport->official_salary;

                        $salaryListReport->setScenario(SalaryReportList::SCENARIO_SALARY_REPORT_LISTS_UPDATE);

                        if ($salaryListReport->validate()) {
                            $salaryListReport->save();
                        } else {
                            return $this->addError(Processor::ERROR_PARAM,
                                Yii::t('yii', 'Sorry, but the entered data is not correct'));
                        }

                    } else {
                        return $this->addError(Processor::ERROR_PARAM,
                            Yii::t('yii', 'Sorry, but this report period is locked. It is not editable'));
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM,
                        Yii::t('yii', 'This salary list not exist. It is not editable'));
                }
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM,
                Yii::t('yii', 'You have no permission for this action'));
        }
    }

}