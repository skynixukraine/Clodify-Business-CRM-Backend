<?php
/**
 * Created by Skynix Team
 * Date: 23.08.17
 * Time: 12:29
 */

namespace viewModel;


use app\components\DateUtil;
use app\models\SalaryReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class FinancialReportCreate
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-6
 * @author  Oleksii Griban (Skynix)
 */
class SalaryReportCreate extends ViewModelAbstract
{

    public function define()
    {
        // TODO: Implement define() method.

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {

            if ($this->model->report_year) {

                $reportDate = $this->model->report_year . '-' . $this->model->report_date . '-01';
                $reportDate = $this->model->report_year . '-' . $this->model->report_date . '-' . date('t', strtotime($reportDate));

            } else {

                $reportDate = DateUtil::getLastDayDateByMonth($this->model->report_date);

            }

            if (!SalaryReport::validateSalaryReportDate($reportDate)) {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'The salary report is already created for this month'));
            }

            $this->model->report_date = $reportDate;
            $totalUsers = User::find()
                ->where(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_PM],
                    'is_active' => 1,
                    'is_delete' => 0,
                    'is_system' => 0
                ])->count('*');
            $this->model->total_employees = $totalUsers;

            if ($this->validate() && $this->model->save()) {

                $this->setData([
                    'report_id' => $this->model->id
                ]);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

}