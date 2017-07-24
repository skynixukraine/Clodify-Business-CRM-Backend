<?php
/**
 * Created by Skynix Team
 * Date: 21.07.17
 * Time: 12:29
 */

namespace viewModel;


use app\components\DateUtil;
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
        // TODO: Implement define() method.

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {

            $reportDate = DateUtil::convertDateToUnix($this->model->report_date);
            $query = "date_format(from_unixtime(report_date), '%Y-%m')";

            $financialReportDate = FinancialReport::find()
                ->select(['id'])
                ->where([$query => date('Y-m', $reportDate)])
                ->all();

            if (!$financialReportDate) {

                $this->model->report_date = $reportDate;

                if ($this->validate() && $this->model->save()) {

                    $this->setData([
                        'report_id' => $this->model->id
                    ]);
                }

            } else {
                return $this->addError(
                    Processor::ERROR_PARAM,
                        Yii::t('yii', 'The report is already created'));
            }

        }

    }

}