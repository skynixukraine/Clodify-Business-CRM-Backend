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
use app\models\Report;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\Project;
use yii\log\Logger;

class CreateEditReport extends ViewModelAbstract
{

    public function define()
    {
        $oldHours = 0;
        $reportId       = Yii::$app->request->getQueryParam('id');
        $userId = $this->getAccessTokenModel()->user_id;

        if( $reportId ) {
            $this->model = Report::findOne($reportId);
            $oldHours = $this->model->hours;
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

        if(($reportId && ($this->model->user_id == $userId )) || (!$reportId)) {


            if ($this->validate()) {

                $totalHoursOfThisDay = $this->model->sumHoursReportsOfThisDay($this->getAccessTokenModel()->user_id, $this->model->date_report);
                $project = Project::findOne($this->model->project_id);
                if ($project->status == Project::STATUS_INPROGRESS) {
                    $date_end = Invoice::getInvoiceWithDateEnd($this->model->project_id);
                    $dte = Project::findOne(['id' => $this->model->project_id])->date_start;
                    if (DateUtil::compareDates(DateUtil::reConvertData($this->model->date_report), DateUtil::reConvertData($dte))) {
                        return $this->addError(Processor::ERROR_PARAM, "Date report can not be earlier then project's date start");
                    }

                    if (!$this->model->invoice_id && ($date_end == null || $this->model->date_report == null ||
                            DateUtil::compareDates(DateUtil::reConvertData($date_end), DateUtil::reConvertData($this->model->date_report)))
                    ) {
                        if ($this->model->hours < 0.1) {
                            return $this->addError(Processor::ERROR_PARAM, 'Hours must be at least 0.1');
                        }
                        if (strlen(trim($this->model->task)) <= 19) {
                            return $this->addError(Processor::ERROR_PARAM, 'Task should contain at least 20 characters.');
                        }

                        if ($this->validate()) {
                            $user_id = $this->getAccessTokenModel()->user_id;
                            $user = User::findOne($user_id);

                            $salary = $delayedSalaryNote ? $delayedSalaryNote->value : $user->salary;

                            $this->model->cost = $this->model->hours * ($salary / Report::SALARY_HOURS);
                            $this->model->reporter_name = $user->first_name . ' ' . $user->last_name;
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
                        return $this->addError(Processor::ERROR_PARAM, 'The invoice has been created on this project');
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