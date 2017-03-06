<?php
/**
 * Created by Skynix Team
 * Date: 02.03.17
 * Time: 13:58
 */

namespace viewModel;

use app\components\DateUtil;
use app\models\Invoice;
use app\models\Report;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\Project;
use yii\log\Logger;

class ReportsCreate extends ViewModelAbstract
{

    public function define()
    {
        $this->model->setAttributes($this->postData);
        $this->model->user_id = Yii::$app->user->id;
        $this->model->date_added = date('Y-m-d');
        $this->model->date_report = DateUtil::convertData($this->model->date_report);

        if ($this->model->date_report > date('Y-m-d')) {
            return $this->addError(Processor::ERROR_PARAM, 'You can not report in advance');
        }

        //  convert 8,1 to 8.1 before validation
        if (strpos($this->model->hours, ',')) {
            str_replace(',', '.', $this->model->hours);
        }

        if ($this->validate()) {

                $totalHoursOfThisDay = $this->model->sumHoursReportsOfThisDay(Yii::$app->user->id, $this->model->date_report);
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
                            $user = User::findOne(Yii::$app->user->id);
                            $this->model->cost = $this->model->hours * ($user->salary / Report::SALARY_HOURS);
                            if (($result = $totalHoursOfThisDay + $this->model->hours) <= 12) {
                                Yii::$app->user->getIdentity()->last_name;
                                if ($this->model->save()) {
                                    $this->setData(['report_id' => $this->model->id]);
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
                            return $this->addError(Processor::ERROR_PARAM, implode(' ',$this->model->getFirstErrors()));
                        }
                    } else {
                        return $this->addError(Processor::ERROR_PARAM, 'The invoice has been created on this project');
                    }
                }

        }



    }
}