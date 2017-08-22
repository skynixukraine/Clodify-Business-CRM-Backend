<?php
/**
 * Created by Skynix Team
 * Date: 25.07.17
 * Time: 13:48
 */

namespace viewModel;

use Yii;
use app\models\FinancialYearlyReport;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class FinancialReportYearly
 * @see     https://jira-v2.skynix.company/browse/SI-1032
 * @package viewModel
 */
class FinancialReportYearly extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {

            $financialReport = FinancialYearlyReport::find()->all();
            if ($financialReport) {

                foreach ($financialReport as $key => $finRep) {
                    $financialReport[$key] = [
                        'id'  => $finRep->id,
                        'year' => $finRep->year,
                        'income' => $finRep->income,
                        'expense_constant' => $finRep->expense_constant,
                        'investments' => $finRep->investments,
                        'expense_salary' => $finRep->expense_salary,
                        'difference' => $finRep->difference,
                        'bonuses' => $finRep->bonuses,
                        'corp_events' => $finRep->corp_events,
                        'profit' => $finRep->profit,
                        'balance' => $finRep->balance,
                        'spent_corp_events' => $finRep->spent_corp_events,
                    ];
                }

            } else {
                $financialReport = [];
            }
            $this->setData($financialReport);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }
}