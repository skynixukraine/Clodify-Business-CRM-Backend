<?php
/**
 * Created by Skynix Team
 * Date: 15.09.17
 * Time: 12:00
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
 * @see     https://jira.skynix.company/browse/SCA-23
 * @author  Igor (Skynix)
 */
class FinancialReportUnlock extends ViewModelAbstract
{

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN])) {
            $id = Yii::$app->request->getQueryParam('id');
            $financialReport = FinancialReport::findOne($id);
            $financialReport->is_locked = FinancialReport::NOT_LOCKED;
            $financialReport->save();
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

}