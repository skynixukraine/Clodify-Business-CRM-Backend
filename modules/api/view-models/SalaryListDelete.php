<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 29.08.17
 * Time: 17:18
 */

namespace viewModel;

use Yii;
use app\models\FinancialReport;
use app\models\SalaryReportList;
use app\models\User;
use app\modules\api\components\Api\Processor;

class SalaryListDelete extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
            $salaryReportId = Yii::$app->request->getQueryParam('sal_report_id');
            $salaryReportListId = Yii::$app->request->getQueryParam('id');
            if (!FinancialReport::checkIsLockForSalaryList($salaryReportId)) {
                $salaryListReport = SalaryReportList::findOne($salaryReportListId);
                $salaryListReport->delete();
            } else {
                return $this->addError(Processor::ID_PARAM, Yii::t('yii', 'The list can not be deleted because the financial report is locked'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}