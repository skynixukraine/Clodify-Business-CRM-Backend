<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/9/18
 * Time: 10:41 PM
 */

namespace viewModel;

use app\models\FinancialReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * @see https://jira.skynix.co/browse/SCA-176
 * Class FinancialIncomeCreate
 * @package viewModel
 */
class FinancialIncomeCreate extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            if ( ($id = Yii::$app->request->getQueryParam('id') ) &&
                ( $financialReport = FinancialReport::findOne($id) )) {
                if (!$financialReport->is_locked) {

                    $this->model->financial_report_id   = $id;
                    $this->model->added_by_user_id      = Yii::$app->user->id;
                    $this->model->save();

                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Financial Report is locked any operations are forbidden'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to add income for not existent financial report'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}