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
            $date = date("Y-") . $this->model->report_date . '-01';

            $reportDate = DateUtil::convertDateToUnix($date);

            if (!SalaryReport::validateSalaryReportDate($reportDate)) {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'The report is already created or time for report invalid'));
            }

            $this->model->report_date = $reportDate;

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