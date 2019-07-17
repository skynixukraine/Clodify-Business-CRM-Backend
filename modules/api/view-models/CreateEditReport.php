<?php
/**
 * Created by Skynix Team
 * Date: 02.03.17
 * Time: 13:58
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\DelayedSalary;
use app\models\Invoice;
use app\models\Milestone;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\models\FinancialReport;
use app\models\Setting;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\Project;
use yii\log\Logger;

class CreateEditReport extends ViewModelAbstract
{
    /** @var  Report */
    protected $model;

    public function define()
    {
        $oldHours = 0;
        $reportId       = Yii::$app->request->getQueryParam('id');
        $userId = $this->getAccessTokenModel()->user_id;

        if( $reportId ) {
            $this->model = Report::findOne($reportId);

            if ($this->model->invoice) {
                return $this->addError('project_id', 'You can not edit this report, because it was already invoiced.');
            }

            $oldHours = $this->model->hours;
            $this->model->setScenario(Report::SCENARIO_UPDATE_REPORT);
            $this->model->setAttributes($this->postData);
            $this->model->date_report = DateUtil::convertData($this->model->date_report);
            if (strpos($this->model->hours, ',')) {
                str_replace(',', '.', $this->model->hours);
            }
        } else {
            $this->model->setAttributes($this->postData);
            $this->model->date_added = date('Y-m-d');
            $this->model->date_report = DateUtil::convertData($this->model->date_report);
            $this->model->user_id = $userId;
        }

        if ($this->model->date_report === null) {
            return $this->addError(Processor::ERROR_PARAM, 'Date report can\'t be blank');
        }

        if ($this->model->date_report > date('Y-m-d')) {
            return $this->addError(Processor::ERROR_PARAM, 'You can not report in advance');
        }

        $dateChuncks = explode("-", $this->model->date_report);

        $delayedSalaryNote = DelayedSalary::find()
            ->andWhere(['user_id' => $userId])
            ->andWhere(['month' => $dateChuncks[1]])
            ->andWhere(['is_applied' => 0])
            ->one();

        //  convert 8,1 to 8.1 before validation
        if (strpos($this->model->hours, ',')) {
            str_replace(',', '.', $this->model->hours);
        }

        if (($reportId && ($this->model->user_id == $userId )) || (! $reportId)) {
            if ($this->validate()) {
                $totalHoursOfThisDay = Report::sumHoursReportsOfThisDay($userId, $this->model->date_report);
                $project = Project::findOne($this->model->project_id);

                if ($project->status === Project::STATUS_INPROGRESS) {
                    if (strtotime($this->model->date_report) < strtotime($project->date_start)) {
                        return $this->addError(Processor::ERROR_PARAM, "Date report can not be earlier then project's date start");
                    }

                    if (Invoice::existsInvoiceWithDate($project, $this->model->date_report)) {
                        return $this->addError(Processor::ERROR_PARAM, 'Invoice already created for this date');
                    }

                    if ($this->model->hours < 0.1) {
                        return $this->addError(Processor::ERROR_PARAM, 'Hours must be at least 0.1');
                    }

                    if (strlen(trim($this->model->task)) <= 19) {
                        return $this->addError(Processor::ERROR_PARAM, 'Task should contain at least 20 characters.');
                    }

                    if ($this->validate()) {

                        $user_id    = $this->getAccessTokenModel()->user_id;
                        $user       = User::findOne($user_id);

                        $salary = $delayedSalaryNote && $delayedSalaryNote->value > 0 ? $delayedSalaryNote->value : $user->salary;


                        $financialReport = FinancialReport::findOne(['MONTH(report_date)=:month'], [':month' => date('n', strtotime($this->model->date_report))]);

                        if(!is_null($financialReport))
                            $numberOfWorkingHoursInTheMonth = $financialReport->num_of_working_days > 0 ? $financialReport->num_of_working_days * 8 : 168;
                        else
                            $numberOfWorkingHoursInTheMonth = Report::SALARY_HOURS;


                        $expensesRatio = 1;
                        if($project->type === 'FIXED_PRICE') {

                            if(($milestone = Milestone::find()
                                ->where(['and', 'start_date<=NOW()', 'end_date>=NOW()'])
                                ->andWhere(['project_id' => $project->id])
                                ->orderBy(['id' => 'DESC'])
                                ->one())){

                                $milestone->estimated_amount;
                                $cost_sum = Report::find()
                                    ->where([
                                        'and',
                                        'date_report>=:milestone_start',
                                        'date_report<=:milestone_end'
                                        ], [':milestone_start' => $milestone->start_date, ':milestone_end' => $milestone->end_date ])
                                    ->andWhere(['project_id' => $project->id])
                                    ->andWhere(['is_delete' => 0])
                                    ->select('SUM(cost)')->scalar();

                                $cost_sum = floatval($cost_sum);

                                if(($milestone->estimated_amount - $cost_sum * 2) > 0){

                                    $expensesRatio = 1;

                                } else {

                                    $expensesRatio = 1 + Setting::getLaborExpensesRatio()/100;
                                }

                            } else if (($milestone = Milestone::find()
                                ->where(['and', 'start_date<=NOW()', 'end_date<=NOW()'])
                                ->andWhere(['project_id' => $project->id])
                                ->orderBy(['id' => 'DESC'])
                                ->one())) {

                                $cost_sum = Report::find()
                                    ->where([
                                        'and',
                                        'date_report>=:milestone_start',
                                        'date_report<=:milestone_end'
                                    ], [':milestone_start' => $milestone->start_date, ':milestone_end' => $milestone->end_date ])
                                    ->andWhere(['project_id' => $project->id])
                                    ->andWhere(['is_delete' => 0])
                                    ->select('SUM(cost)')->scalar();

                                $cost_sum = floatval($cost_sum);

                                if(($milestone->estimated_amount - $cost_sum * 2) > 0){
                                    $expensesRatio = 1 + Setting::getLaborExpensesRatio()/100;
                                } else if(($milestone->estimated_amount - $cost_sum ) > 0) {
                                    $expensesRatio = 1 + Setting::getLaborExpensesRatio()/80;
                                } else if(($milestone->estimated_amount - $cost_sum ) <= 0) {
                                    $expensesRatio = 1 + Setting::getLaborExpensesRatio()/50;
                                }

                            }
                        }

                        $this->model->cost = $this->model->hours *
                            ($salary / $numberOfWorkingHoursInTheMonth) *
                            ($expensesRatio > 0 ? $expensesRatio : 1);

                        if ( ($pD = ProjectDeveloper::findOne(['user_id' => $user->id,
                            'project_id' => $project->id ])) &&
                            $pD->alias_user_id > 0 && $pD->alias_user_id !== $user->id &&
                            ($aliasUser = User::findOne( $pD->alias_user_id ))) {

                            ;
                            $reporterName = $aliasUser->first_name . ' ' . $aliasUser->last_name;

                        } else {

                            $reporterName = $user->first_name . ' ' . $user->last_name;

                        }

                        $this->model->reporter_name = $reporterName;
                        $this->model->user_id = $user_id;
                        $result = $totalHoursOfThisDay - $oldHours + $this->model->hours;
                        if ($result <= 12) {
                            if ($this->model->save()) {
                                if(!$reportId) {
                                    $this->setData(['report_id' => $this->model->id]);
                                } else {
                                    $this->setData([]);
                                }
                                if ($project->validate()) {
                                    $project->save(true, ["total_logged_hours", "total_paid_hours"]);
                                }

                            } else {

                                Yii::getLogger()->log($this->model->getErrors(), Logger::LEVEL_ERROR);
                                return $this->addError(Processor::ERROR_PARAM, 'Report can not be saved');
                            }

                        } else {
                            return $this->addError('hours', 'You can not add/edit this report. Maximum total hours is 12');
                        }
                    } else {
                        Yii::getLogger()->log($this->model->getErrors(), Logger::LEVEL_ERROR);
                        return $this->addError(Processor::ERROR_PARAM, implode(' ', $this->model->getFirstErrors()));
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'The project is not accessible for posting reports'));
                }
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app','You can edit only own reports'));
        }
    }
}