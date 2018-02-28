<?php
/**
 * Created by Skynix Team
 * Date: 25.08.17
 * Time: 16:11
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\FinancialReport;
use app\models\SalaryReport;
use app\models\SalaryReportList;
use app\models\User;
use app\modules\api\components\Api\Message;
use app\modules\api\components\Api\Processor;
use mPDF;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class SalaryReportDownload
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-18
 * @author  Oleksii Griban (Skynix)
 */
class SalaryReportDownload extends ViewModelAbstract
{

    public function define()
    {
        // TODO: Implement define() method.

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {

            $id = Yii::$app->request->getQueryParam('id');

            $salaryReport = SalaryReport::findOne(['id' => $id]);

            if ($salaryReport) {
                $salaryReportData = ArrayHelper::toArray($salaryReport, [
                    SalaryReport::className() => [
                        'total_to_pay' => 'total_to_pay',
                        'currency_rate',
                        'total_to_pay_uah' => function ($salaryReport) {
                            return $salaryReport->total_to_pay * $salaryReport->currency_rate;
                        },
                        'financial_report_status' => function ($salaryReport) {
                            return FinancialReport::isLock($salaryReport->report_date) ? 'Locked' : 'Unlocked';
                        }
                    ],
                ]);


                $salaryReportList = SalaryReportList::find()
                    ->andWhere(['salary_report_id' => $salaryReport->id])
                    ->all();

                if ($salaryReportList) {
                    $salaryReportListData = ArrayHelper::toArray($salaryReportList, [
                        SalaryReportList::className() => [
                            'salary',
                            'currency_rate',
                            'bonuses',
                            'day_off',
                            'overtime_value',
                            'hospital_value',
                            'subtotal',
                            'official_salary',
                            'total_to_pay' => function ($salaryReport) {
                                return $salaryReport->total_to_pay;
                            },
                            'first_name' => function ($salaryReport) {
                                return $salaryReport->user->first_name ?: '';
                            },
                            'last_name' => function ($salaryReport) {
                                return $salaryReport->user->last_name ?: '';
                            },
                            'is_admin' => function ($salaryReportList){
                                return $salaryReportList->user->role == User::ROLE_ADMIN;
                            },

                            // next params ignored for admin in PDF
                            'worked_hours' => function ($salaryReportList) {
                                return SalaryReportList::sumReportedHoursForMonthPerUser($salaryReportList);
                            },
                            'approved_hours' => function ($salaryReportList) {
                                return SalaryReportList::sumApprovedHoursForMonthPerUser($salaryReportList);
                            }
                        ],
                    ]);
                }

                $content = Yii::$app->controller->renderPartial('/salary-reports/SalaryReportTemplatePDF', [
                    'salaryReportData' => $salaryReportData,
                    'salaryReportListData' => $salaryReportListData ?: [],
                    'salaryReportDate' => DateUtil::convertDateFromUnix($salaryReport->report_date, 'F Y'),
                    'completion' => count($salaryReportListData) . '(' . $this->countEmployedUsers() . ')'
                ]);
                $pdf = new mPDF();
                @$pdf->WriteHTML($content);
                return $pdf->Output('SalaryReport'
                    . $salaryReport->id . '_'
                    . DateUtil::convertDateFromUnix($salaryReport->report_date, 'Y_m')
                    . '.pdf', 'D');

            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'Salary report not found'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Message::get(Processor::CODE_NOT_ATHORIZED));
        }
    }

    /**
     * @return int|string
     */
    private function countEmployedUsers()
    {
        return User::find()
            ->andWhere(['is_active' => User::ACTIVE_USERS])
            ->andWhere(['is_delete' => !User::DELETED_USERS])
            ->andWhere(['not', ['salary' => null]])
            ->count();
    }
}