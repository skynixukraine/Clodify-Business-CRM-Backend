<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/10/18
 * Time: 5:53 PM
 */

namespace viewModel;

use app\components\DataTable;
use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * @see https://jira.skynix.co/browse/SCA-178
 * Class FinancialIncomeDelete
 * @package viewModel
 */
class FinancialIncomeDelete extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            if ( ($id = Yii::$app->request->getQueryParam('id') ) &&
                ( $financialReport = FinancialReport::findOne($id) )) {


                if (!$financialReport->is_locked) {

                    if ( ($itemId = Yii::$app->request->getQueryParam('income_item_id')) &&
                        ( $financialIncomeItem = FinancialIncome::findOne($itemId) ) &&
                        ($financialIncomeItem->financial_report_id === $financialReport->id) ) {

                        if ( (User::hasPermission([User::ROLE_SALES]) &&
                            $financialIncomeItem->added_by_user_id === Yii::$app->user->id) ||
                            User::hasPermission([User::ROLE_ADMIN])) {

                            $financialIncomeItem->delete();

                        }  else {

                            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You do not have an access to delete this item.'));

                        }

                    } else {

                        return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Financial Income Item has not been found.'));

                    }

                } else {

                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Financial Report is locked any operations are forbidden'));
                }

            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to fetch income for not existent financial report'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}