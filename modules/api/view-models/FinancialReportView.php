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

            $financialReport = FinancialReport::find()
                ->where([FinancialReport::tableName() . '.id' => $id])
                ->one();

            if ($financialReport) {
                $financialReport = ArrayHelper::toArray($financialReport, [
                    'app\models\FinancialReport' => [
                        'id',
                        'report_date' => function ($financialReport) {
                            return DateUtil::convertDateFromUnix($financialReport->report_date);
                        },
                        'currency',
                        'expense_salary',
                        'income' => function ($financialReport) {
                            return $this->convertElement($financialReport->income);
                        },
                        'expense_constant' => function ($financialReport) {
                            return $this->convertElement($financialReport->expense_constant);
                        },
                        'investments' => function ($financialReport) {
                            return $this->convertElement($financialReport->investments);
                        },
                        'spent_corp_events' => function ($financialReport) {
                            return $this->convertElement($financialReport->spent_corp_events);
                        },
                    ],
                ]);
                if (!User::hasPermission([User::ROLE_ADMIN])) {
                    unset ($financialReport['income']);
                }

                $this->setData($financialReport);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }

    /**
     * convert date element to Jul 23 format
     *
     * @param $string
     * @return mixed
     */
    private function convertElement($string)
    {
        if ($string) {
            $array = json_decode($string);
            foreach ($array as $arr) {
                if (!empty ($arr)) {
                    $arr->date = date('F j', $arr->date);
                }
            }
            return $array;
        }
        return null;
    }
}