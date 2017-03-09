<?php

namespace viewModel;

use app\components\DateUtil;
use app\models\Invoice;
use app\models\Report as ReportModel;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\Project;
use yii\log\Logger;
/**
 * Created by Skynix Team
 * Date: 09.03.17
 * Time: 14:39
 */
class ReportsEdit extends ViewModelAbstract
{

    public function define()
    {
        $userId         = $this->getAccessTokenModel()->user_id;

        $reportId       = Yii::$app->request->getQueryParam('id');

        $this->model    = ReportModel::findOne($reportId);
        $oldHours  = $this->model->hours;
        $this->model->setAttributes($this->postData);

        $this->model->date_report = DateUtil::convertData($this->model->date_report);

        if (strpos($this->model->hours, ',')) {
                str_replace(',', '.', $this->model->hours);
            }

        if($this->model) {
            //User can edit only own report
            if ($this->model->user_id == $userId) {
                if ($this->validate()) {
                    $totalHoursOfThisDay = $this->model->sumHoursReportsOfThisDay( $this->getAccessTokenModel()->user_id, $this->model->date_report);
                    $project = Project::findOne($this->model->project_id);
                    if (in_array($project->status, [Project::STATUS_INPROGRESS, Project::STATUS_ONHOLD])) {
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
                                $this->model->cost = $this->model->hours * ($user->salary / ReportModel::SALARY_HOURS);
                                $this->model->reporter_name = $user->first_name . ' ' . $user->last_name;
                                $this->model->user_id = $user_id;
                                if (($result = $totalHoursOfThisDay - $oldHours + $this->model->hours) <= 12) {
                                    if ($this->model->save()) {
                                        $this->setData([]);
                                        if ($project->validate()) {
                                            $project->save(true, ["total_logged_hours", "total_paid_hours"]);
                                        }
                                    } else {
                                            Yii::getLogger()->log($this->model->getErrors(), Logger::LEVEL_ERROR);
                                            return $this->addError(Processor::ERROR_PARAM, 'Report can not be saved');
                                    }
                                }else {
                                    return $this->addError('hours', 'You can not add/edit this report. Maximum total hours is 12');
                                }
                            }else {
                                Yii::getLogger()->log($this->model->getErrors(), Logger::LEVEL_ERROR);
                                return $this->addError(Processor::ERROR_PARAM, implode(' ',$this->model->getFirstErrors()));
                            }
                        } else {
                            return $this->addError(Processor::ERROR_PARAM, 'The invoice has been created on this project');
                        }
                        }

                    }
            } else {
                $this->addError(Processor::ERROR_PARAM, Yii::t('app','You can edit only own reports'));
            }
        }
    }
}