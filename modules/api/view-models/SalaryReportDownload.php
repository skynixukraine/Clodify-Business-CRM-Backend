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
use Mpdf\Mpdf;
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
            $salaryReportListData = [];

            if ($salaryReport) {
                $salaryReportData = ArrayHelper::toArray($salaryReport, [
                    SalaryReport::className() => [
                        'currency_rate',
                        'total_to_pay',
                        'subtotal',
                        'total_to_pay_uah' => function ($salaryReport) {
                            $salaryReport->currency_rate = $salaryReport->currency_rate ? $salaryReport->currency_rate : 1;
                            return ceil($salaryReport->subtotal * $salaryReport->currency_rate);
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
                            'vacation_value',
                            'vacation_days',
                            'non_approved_hours',
                            'is_approving_hours_enabled'    => function ($salaryReport) {
                                return $salaryReport->user->pay_only_approved_hours;
                            },
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
                    if ( !$salaryReportData['total_to_pay'] ) {

                        $salaryReportData['total_to_pay']	= round(SalaryReportList::getSumOf($salaryReportList, 'total_to_pay'));
                        $salaryReportData['currency_rate']	= FinancialReport::getCurrency($salaryReport->report_date);
                        $salaryReportData['subtotal']       = round(SalaryReportList::getSumOf($salaryReportList, 'subtotal'));
                        $salaryReportData['total_to_pay_uah'] = round($salaryReportData['subtotal'] * $salaryReportData['currency_rate']);
                    }

                }

                $salaryReportData['total_to_payout_uah'] = round($salaryReportData['total_to_pay']
                    - SalaryReportList::getSumOfSalariesOfFOPs($salaryReportList));

                $content = Yii::$app->controller->renderPartial('/salary-reports/SalaryReportTemplatePDF', [
                    'salaryReportData' => $salaryReportData,
                    'salaryReportListData' => $salaryReportListData ?: [],
                    'salaryReportDate' => DateUtil::convertDateFromUnix($salaryReport->report_date, 'F Y'),
                    'completion' => count($salaryReportListData) . '(' . $this->countEmployedUsers() . ')'
                ]);
                $pdf = new Mpdf();
                @$pdf->WriteHTML($content);

                $name = 'SalaryReport_' . $salaryReport->id . '_' .
                    DateUtil::convertDateFromUnix($salaryReport->report_date, 'Y_m') . '.pdf';

                $this->setData(
                    [
                        'pdf'  => base64_encode($pdf->Output($name, 'S')),
                        'name' => $name
                    ]
                );

            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Salary report not found'));
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
            ->andWhere(['in', 'role', [User::ROLE_DEV, User::ROLE_PM, User::ROLE_SALES, User::ROLE_FIN]])
            ->andWhere(['>', 'salary', 100])
            ->count();
    }
}