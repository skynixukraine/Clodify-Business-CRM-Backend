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
use app\models\Milestone;
use app\models\Project;
use app\models\Report;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use yii\helpers\ArrayHelper;

class FinancialBonusesFetch extends ViewModelAbstract
{
    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            /** @var $financialReport FinancialReport */
            if ( ($id = Yii::$app->request->getQueryParam('id') ) &&
                ( $financialReport = FinancialReport::findOne($id) )) {


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

                    $dateFrom   = date('Y-m-01', $financialReport->report_date);
                    $toDate     = date('Y-m-t', $financialReport->report_date);

                    /** @var $project Project */
                    if ( ($project = $finIncome->getProject()->one() ) ) {

                        $milestones = [];
                        //if a project_type=FIXED_PRICE and only if milestones are closed this month calculate them and for expenses use reports for milestone periods start_date ~ closed_date
                        if ( $project->type === Project::TYPE_FIXED_PRICE ) {

                            $milestonesList = Milestone::find()
                                ->where([
                                    'project_id'    => $project->id,
                                    'status'        => Milestone::STATUS_CLOSED
                                ])
                                ->andWhere(['between', 'closed_date', $dateFrom, $toDate])
                                ->all();

                            $milestones = ArrayHelper::toArray($milestonesList, [
                                'app\models\Milestone' => [
                                    'id',
                                    'name',
                                    'start_date',
                                    'end_date',
                                    'closed_date'

                                ],
                            ]);

                            foreach ( $milestones as $milestone ) {

                                if ( strtotime( $milestone['start_date'] ) < strtotime($dateFrom) ) {

                                    $dateFrom = $milestone['start_date'];

                                }
                                if ( strtotime($milestone['closed_date']) < strtotime($toDate) ) {

                                    $toDate = $milestone['closed_date'];

                                }

                            }

                        }

                        $project = [
                            'id'            => $project->id,
                            'name'          => $project->name,
                            'milestones'    => $milestones
                        ];

                    } else {

                        $project = ['name' => "Unknown"];
                    }
                    $expenses = Report::getReportsCostByProjectAndDates($finIncome->project_id, $dateFrom, $toDate);

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