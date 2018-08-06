<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 8/5/18
 * Time: 8:01 PM
 */

namespace viewModel;
use app\components\DateUtil;
use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\Report;
use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\models\User;
use app\modules\api\components\Api\Processor;

class ReviewsFetch extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            $userId     = Yii::$app->request->getQueryParam('id');
            $fromDate   = Yii::$app->request->getQueryParam('from_date', date('01/m/Y'));
            $toDate     = Yii::$app->request->getQueryParam('to_date', date('t/m/Y'));
            $query = User::find()
                ->where(['role'=>
                    [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_PM],
                    'is_active' => 1,
                    'is_delete' => 0
                ]);

            if ( $userId > 0 ) {

                $query->andWhere(['id' => $userId]);

            }
            $now = time();
            if ( !(( $fromDate = DateUtil::convertData( $fromDate ) ) &&
                ( $fromDate = strtotime($fromDate) ) &&
                $fromDate > 0 && $fromDate < $now )) {

                $fromDate = strtotime(date('01/m/Y'));

            }
            if ( !(( $toDate = DateUtil::convertData( $toDate ) ) &&
                ( $toDate = strtotime($toDate) ) &&
                $toDate > 0 && $toDate <= $now ) && $toDate > $fromDate) {

                $toDate = time();

            }

            $query->limit(1000);
            $query->orderBy(['id'   => 'ASC']);
            $reviewsData = [];
            if ( ($reviews = $query->all() ) )  {
                /**
                 * @var  $k integer
                 * @var  $v User
                 */
                foreach ($reviews as $k => $v) {

                    $amount = FinancialIncome::find()
                        ->leftJoin(FinancialReport::tableName(),
                            FinancialIncome::tableName() . '.financial_report_id=' .
                                FinancialReport::tableName() . '.id')
                        ->where(['between', 'report_date', $fromDate, $toDate])
                        ->andWhere(['developer_user_id' => $v->id])
                        ->sum('amount');

                    $expenses = Report::getReportsCostByUserAndDates( $v->id, date('Y-m-d', $fromDate), date('Y-m-d', $toDate));

                    $reviewsData[] = [
                        "id"            => $k+1,
                        "earned"        => ($amount - $expenses),
                        "date_start"    => date("d/m/Y", $fromDate),
                        "date_end"      => date("d/m/Y", $toDate),
                        "user"        => [
                            "id"            => $v->id,
                            "first_name"    => $v->first_name,
                            "last_name"     => $v->last_name,
                        ]
                    ];
                }
            }
            $this->setData($reviewsData);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}