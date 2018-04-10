<?php
/**
 * Created by Skynix Team
 * Date: 12.02.17
 * Time: 14:48
 */

namespace app\commands;

use app\models\Report;
use app\models\User;
use app\models\Project;
use yii\console\Controller;
use app\models\AvailabilityLog;
use app\models\ProjectDeveloper;


class ReportController extends Controller
{
    /**
     *
     */
    public function actionApproveToday()
    {
        try {
            Report::approveTodayReports();
            echo 0;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            echo $e->getMessage();
        }
    }

    /**
     *
     */
    public function actionIdleTime()
    {
        try {
            $users = User::find()->all();
            $today = date('Y-m-d', time());

            foreach ($users as $user) {
                $h = Report::sumHoursReportsOfThisDay($user->id, $today);

                if ($h && $h < 8) {
                    $log = AvailabilityLog::find()->where(['user_id' => $user->id])->one();

                    $dateWhenAvailableRequestPosted = date('Y-m-d', $log->date);

                    // if posted today and is_available=true
                    if ($today == $dateWhenAvailableRequestPosted && $log->is_available) {

                        $projectId = Project::find()->where(['name' => Project::INTERNAL_TASK])->one()->id;

                        // create project-dev note if not exist
                        $pDev = ProjectDeveloper::findOne([
                            'user_id'       => $user->id,
                            'project_id'    => $projectId]);

                        if(!$pDev){
                            $projectDev = new ProjectDeveloper();
                            $projectDev->user_id = $user->id;
                            $projectDev->project_id = $projectId;
                            $projectDev->save();
                        }

                        // create idle report
                        $report = new Report();
                        $report->project_id = $projectId;
                        $report->user_id = $user->id;
                        $report->task = 'Idle Time - I was waiting for tasks';
                        $report->hours = 8 - $h;
                        $report->date_report = $today;
                        $report->reporter_name = $user->first_name;
                        $report->save();
                    }
                }
            }
            echo 0;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            echo $e->getMessage();
        }
    }
}
