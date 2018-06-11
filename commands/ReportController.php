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
use app\models\WorkHistory;
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

            if ( date('N') < 6 ) {


                $itemsReported = \Yii::$app->db->createCommand("
                    SELECT users.id, sum(reports.hours) AS s FROM users 
                    LEFT JOIN reports ON users.id=reports.user_id 
                    WHERE users.role IN('ADMIN', 'FIN', 'DEV', 'PM', 'SALES') AND
                    users.is_active=1 AND
                     ( reports.date_report IS NULL OR reports.date_report =':date_report' )
                    GROUP By users.id
                    HAVING s > 6;", [
                    ':date_report'  => date('Y-m-d')
                ])->queryAll();
                foreach ( $itemsReported as $user ) {

                    if ( $user['s'] > 8 ) {

                        WorkHistory::create(
                            WorkHistory::TYPE_USER_EFFORTS,
                            $user['id'],
                            \Yii::t('app', '+ Reported more then 8 hours - Overtimed, reported {hours} hours on {date}', [
                                'hours' => $user['s'],
                                'date'  => date('Y-m-d')
                            ])
                        );

                    }
                }
                //BE sure this is working day and other were reported hours
                if ( count($itemsReported ) > 5) {

                    //Fetch users with less then 8 reported hours
                    $items = \Yii::$app->db->createCommand("
                        SELECT users.*, sum(reports.hours) AS s FROM users 
                        LEFT JOIN reports ON users.id=reports.user_id 
                        WHERE users.role IN('ADMIN', 'FIN', 'DEV', 'PM', 'SALES') AND
                        users.is_active=1 AND
                         ( reports.date_report IS NULL OR reports.date_report =':date_report' )
                        GROUP By users.id
                        HAVING s < 6;", [
                        ':date_report'  => date('Y-m-d')
                    ])->queryAll();

                    foreach ( $items as $user ) {

                        $mail = \Yii::$app->mailer->compose('missedHoursNotification', [
                            'username'  => $user['first_name'],
                            'hours'     => $user['s']
                        ])
                            ->setFrom(\Yii::$app->params['adminEmail'])
                            ->setTo($user['email'])
                            ->setSubject('Skynix CRM: Missed Hours Notification');

                        $mail->send();

                        WorkHistory::create(
                            WorkHistory::TYPE_USER_FAILS,
                            $user['id'],
                            \Yii::t('app', '- Reported less then 8 hours - Reported only {hours} hours on {date}', [
                                'hours' => $user['s'],
                                'date'  => date('Y-m-d')
                            ])
                        );

                    }

                }

            }





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
                    $log = AvailabilityLog::find()
                        ->where(['user_id' => $user->id])
                        ->orderBy(['id' => SORT_DESC])
                        ->limit(1)
                        ->all();

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
