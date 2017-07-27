<?php
/**
 * Created by Skynix Team
 * Date: 23.07.17
 * Time: 15:17
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\FinancialReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use yii;

/**
 * Class FinancialReportUpdate
 * @package viewModel
 */
class FinancialReportUpdate extends ViewModelAbstract
{

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {

            $financialReport = FinancialReport::findOne($id);

            if (isset($this->postData['income'])) {
                $this->postData['income'] = json_encode($this->postData['income']);
            }

            if (isset($this->postData['expense_constant'])) {
                $this->postData['expense_constant'] = json_encode($this->postData['expense_constant']);
            }

            if (isset($this->postData['investments'])) {
                $this->postData['investments'] = json_encode($this->postData['investments']);
            }

            if (isset($this->postData['report_date'])) {
                $reportDate = DateUtil::convertDateToUnix($this->postData['report_date']);

                if (!FinancialReport::validateReportDate($reportDate)) {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'The report is already created'));
                }

                $this->postData['report_date'] = $reportDate;
            }

            $financialReport->setAttributes(
                array_intersect_key($this->postData, array_flip($this->model->safeAttributes())), false
            );

            if ($financialReport->validate()) {
                $financialReport->save();
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'This report can not be updated!'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}