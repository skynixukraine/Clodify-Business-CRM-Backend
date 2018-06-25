<?php
/**
 * Created by Skynix Team.
 * User: igor
 * Date: 22.08.17
 * Time: 15:33
 */

namespace viewModel;

use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\SalaryReportList;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class FinancialReportFetch
 * @see     https://jira.skynix.company/browse/SCA-7
 * @package viewModel
 */
class SalaryReportFetchList extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN,])) {

            $listId = Yii::$app->request->getQueryParam('listId');
            $order = Yii::$app->request->getQueryParam('order');
            $start = Yii::$app->request->getQueryParam('start') ?: 0;
            $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
            $id = Yii::$app->request->getQueryParam('id');

            $query = SalaryReportList::find()
                ->where([SalaryReportList::tableName() . '.salary_report_id' => $id]);

            if ( $listId > 0 ) {
                $query = SalaryReportList::find()
                    ->where([SalaryReportList::tableName() . '.id' => $listId]);

            }

            $dataTable = DataTable::getInstance()
                ->setQuery($query)
                ->setLimit($limit)
                ->setStart($start);

            if ($order) {
                foreach ($order as $name => $value) {
                    $dataTable->setOrder(SalaryReportList::tableName() . '.' . $name, $value);
                }

            } else {
                $dataTable->setOrder(SalaryReportList::tableName() . '.id', 'asc');
            }

            $salaryReportList = $dataTable->getData();


            if ($salaryReportList) {

                /**
                 * @var  $key
                 * @var  $salRepList SalaryReportList
                 */
                foreach ($salaryReportList as $key => $salRepList) {
                    $salaryReportList[$key] = [
                        "id"                         => $salRepList->id,
                        "salary_report_id"           => $salRepList->salary_report_id,
                        "user"                       => $salRepList->user->getPublicInfo(),
                        "salary"                     => $salRepList->salary,
                        "worked_days"                => $salRepList->worked_days,
                        "actually_worked_out_salary" => $salRepList->actually_worked_out_salary,
                        "official_salary"            => $salRepList->official_salary,
                        "hospital_days"              => $salRepList->hospital_days,
                        "hospital_value"             => $salRepList->hospital_value,
                        "bonuses"                    => $salRepList->bonuses,
                        "day_off"                    => $salRepList->day_off,
                        "overtime_days"              => $salRepList->overtime_days,
                        "overtime_value"             => $salRepList->overtime_value,
                        "other_surcharges"           => $salRepList->other_surcharges,
                        "subtotal"                   => $salRepList->subtotal,
                        "currency_rate"              => $salRepList->currency_rate,
                        "subtotal_uah"               => $salRepList->subtotal_uah,
                        "total_to_pay"               => $salRepList->total_to_pay,
                        "vacation_days"              => $salRepList->vacation_days,
                        "vacation_value"             => $salRepList->vacation_value,
                        "reported_hours"             => SalaryReportList::sumReportedHoursForMonthPerUser($salRepList),
                        "approved_hours"             => SalaryReportList::sumApprovedHoursForMonthPerUser($salRepList)
                    ];
                }

            } else {
                $salaryReportList = [];
            }
            $data = [
                'lists' => $salaryReportList,
                'total_records' => DataTable::getInstance()->getTotal()
            ];

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

}