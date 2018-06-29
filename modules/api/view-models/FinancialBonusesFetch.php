<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 6/29/18
 * Time: 8:03 PM
 */

namespace viewModel;

use app\components\DataTable;
use app\models\FinancialIncome;
use app\models\FinancialReport;
use app\models\Project;
use app\models\Report;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;

class FinancialBonusesFetch extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            /** @var $financialReport FinancialReport */
            if ( ($id = Yii::$app->request->getQueryParam('id') ) &&
                ( $financialReport = FinancialReport::findOne($id) )) {

                $dateFrom   = date('Y-m-01', $financialReport->report_date);
                $toDate     = date('Y-m-t', $financialReport->report_date);

                $query  = FinancialIncome::find();
                $query->where(['financial_report_id' => $financialReport->id]);
                if ( User::hasPermission([User::ROLE_SALES]) ) {

                    $query->andWhere(['added_by_user_id' => Yii::$app->user->id]);
                }
                $query->orderBy(['project_id' => SORT_DESC]);
                $query->groupBy('project_id');
                $query->select(['SUM(amount) AS sumAmount', 'project_id', 'added_by_user_id']);
                $data = $query->all();

                $incomeItems = [];
                /** @var  $finIncome FinancialIncome */
                foreach ( $data as $finIncome ) {

                    $expenses = Report::getReportsCostByProjectAndDates($finIncome->project_id, $dateFrom, $toDate);
                    /** @var $project Project */
                    if ( ($project = $finIncome->getProject()->one() ) ) {

                        $project = [
                            'id'    => $project->id,
                            'name'  => $project->name
                        ];

                    } else {

                        $project = ['name' => "Unknown"];
                    }
                    /** @var $project Project */
                    /** @var $u User */
                    $incomeItems[] = [
                        'id'        => $finIncome->project_id,
                        'income'    => round( $finIncome->sumAmount ),
                        'expenses'  => round($expenses),
                        'project'   => $project,
                        'bonuses'   => round( ($finIncome->sumAmount - $expenses) * 0.1 ),
                        'added_by'  => [
                            'id'    => $finIncome->added_by_user_id,
                            'name'  => ( $u = $finIncome->getAddedByUser()->one()) ? $u->first_name . ' ' . $u->last_name : "Unknown"
                        ]

                    ];

                }
                $this->setData($incomeItems);


            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to fetch bonuses for not existent financial report'));
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}