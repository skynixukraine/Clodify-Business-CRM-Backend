<?php
/**
 * Created by Skynix Team
 * Date: 11.04.17
 * Time: 18:28
 */

namespace viewModel;

use app\modules\api\components\Api\Processor;
use Yii;
use app\components\DateUtil;
use app\models\User;
use app\models\FinancialReport;
use yii\helpers\ArrayHelper;

/**
 * Class FinancialReportView
 * @package viewModel
 */
class FinancialReportView extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
            $id = Yii::$app->request->getQueryParam('id');

            $financialReport = FinancialReport::findOne(['id' => $id]);

            if ($financialReport) {
                $financialReport = ArrayHelper::toArray($financialReport, [
                    'app\models\FinancialReport' => [
                        'id',
                        'report_date' => function ($financialReport) {
                            return DateUtil::convertDateFromUnix($financialReport->report_date);
                        },
                        'currency',
                        'expense_salary',
                        'num_of_working_days',
                        'expense_constant' => function ($financialReport) {
                            return $financialReport->expense_constant ? json_decode($financialReport->expense_constant) : [];
                        },
                        'investments' => function ($financialReport) {
                            return $financialReport->investments ? json_decode($financialReport->investments) : [];
                        },
                        'spent_corp_events' => function ($financialReport) {
                            return $financialReport->spent_corp_events ? json_decode($financialReport->spent_corp_events) : [];
                        },
                    ],
                ]);

                if (!User::hasPermission([User::ROLE_ADMIN])) {
                    unset ($financialReport['income']);
                }

                $this->setData($financialReport);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }
    }
}