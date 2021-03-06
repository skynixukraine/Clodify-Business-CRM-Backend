<?php
/**
 * Created by Skynix Team
 * Date: 21.07.17
 * Time: 12:29
 */

namespace viewModel;

use app\models\FinancialReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class FinancialReportCreate
 *
 * @package viewModel
 * @see     https://jira-v2.skynix.company/browse/SI-1022
 * @author  Oleksii Griban (Skynix)
 */
class FinancialReportCreate extends ViewModelAbstract
{


    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $reportYear = $this->model->report_year ? $this->model->report_year : date("Y");
            $reportDate = $reportYear . "-" . $this->model->report_date . '-01';
            if (!FinancialReport::validateReportDate($reportDate)) {
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