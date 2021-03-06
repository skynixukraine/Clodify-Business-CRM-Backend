<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 22.08.17
 * Time: 15:33
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\SalaryReportList;
use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\SalaryReport;
use app\models\User;
use app\modules\api\components\Api\Processor;
use app\models\FinancialReport;

/**
 * Class FinancialReportFetch
 * @see     https://jira-v2.skynix.company/browse/SI-1024
 * @package viewModel
 */
class SalaryReportFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {
            $order = Yii::$app->request->getQueryParam('order');
            $start = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
            $filterById = Yii::$app->request->getQueryParam('id');

            $query = SalaryReport::find();

            if ( $filterById > 0 ) {
                $query->andWhere([SalaryReport::tableName() . '.id' => $filterById]);
            }

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(SalaryReport::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(SalaryReport::tableName() . '.id', 'desc');
            }

            $salaryReport = $dataTable->getData();

            if ($salaryReport) {

                $totalUsers = User::find()
                    ->where(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_PM],
                        'is_active' => 1,
                        'is_delete' => 0,
                        'is_system' => 0
                    ])->count('*');

                foreach ($salaryReport as $key => $salRep) {
                    if ( !$salRep->total_salary ) {

                        $salaryReportLists = SalaryReportList::findAll([
                            'salary_report_id' => $salRep->id,
                        ]);

                        $salRep->total_salary = SalaryReportList::getSumOf($salaryReportLists, 'total_to_pay');

                    }
                    $salaryReport[$key] = [
                        'id'                     => $salRep->id,
                        "report_date"            => DateUtil::getMonthYearByDate($salRep->report_date),
                        "total_salary"           => $salRep->total_salary,
                        "official_salary"        => $salRep->official_salary,
                        "bonuses"                => $salRep->bonuses,
                        "hospital"               => $salRep->hospital,
                        "day_off"                => $salRep->day_off,
                        "overtime"               => $salRep->overtime,
                        "other_surcharges"       => $salRep->other_surcharges,
                        "subtotal"               => $salRep->subtotal,
                        "currency_rate"          => $salRep->currency_rate,
                        "total_to_pay"           => $salRep->total_to_pay,
                        "number_of_working_days" => $salRep->number_of_working_days,
                        "total_reported_hours"   => (float)SalaryReport::getTotalReportedHours($salRep),
                        "total_approved_hours"   => (float)SalaryReport::getTotalApprovedHours($salRep),
                        'total_users'            => (int)$totalUsers,
                        'total_lists'            => (int)SalaryReportList::find()
                            ->where([SalaryReportList::tableName() . '.salary_report_id' => $salRep->id])
                            ->count('*'),
                        'is_locked'              => FinancialReport::isLock($salRep->report_date) ? 'Locked' : 'Unlocked',
                        'total_employees'        => $salRep->total_employees
                    ];
                }

            } else {
                $salaryReport = [];
            }
            $data = [
                'reports' => $salaryReport,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}