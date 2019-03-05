<?php
/**
 * Created by Skynix Team
 * Date: 12.02.17
 * Time: 14:48
 */

namespace app\commands;

use Yii;
use app\models\Report;
use app\models\User;
use app\models\Project;
use app\models\WorkHistory;
use yii\console\Controller;
use app\models\AvailabilityLog;
use app\models\ProjectDeveloper;
use yii\log\Logger;

class ReportController extends DefaultController
{
    /**
     *
     */
    public function actionApproveToday()
    {
        try {
            Yii::getLogger()->log('actionApproveToday: running', Logger::LEVEL_INFO);
            Report::approveTodayReports();
            Yii::getLogger()->log('actionApproveToday: Weekday ' .  date('N'), Logger::LEVEL_INFO);

            if ( date('N') < 6 ) {


                $itemsReported = \Yii::$app->db->createCommand("
                    SELECT users.id, sum(reports.hours) AS s FROM users 
                    LEFT JOIN reports ON users.id=reports.user_id 
                    WHERE users.role IN('ADMIN', 'FIN', 'DEV', 'PM', 'SALES') AND
                    users.is_active=1 AND
                    users.is_system=0 AND
                     ( reports.date_report IS NULL OR reports.date_report =:date_report ) AND
                    reports.is_delete=0
                    GROUP By users.id
                    HAVING s > 6;", [
                    ':date_report'  => date('Y-m-d')
                ])->queryAll();

                Yii::getLogger()->log('actionApproveToday: Found ' .  count($itemsReported) . ' reported items', Logger::LEVEL_INFO);
                foreach ( $itemsReported as $user ) {
                    
                    $user['s'] = round($user['s']);
                    if ( $user['s'] > 8 ) {

                        Yii::getLogger()->log('actionApproveToday: Adding benefit ' .  var_export($user, 1) , Logger::LEVEL_INFO);

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
                if ( count($itemsReported ) >= 1) {

                    //Fetch users with less then 8 reported hours
                    $items = \Yii::$app->db->createCommand("
                        SELECT users.*, sum(reports.hours) AS s FROM users 
                        LEFT JOIN reports ON users.id=reports.user_id AND reports.date_report =:date_report
                        WHERE users.role IN('ADMIN', 'FIN', 'DEV', 'PM', 'SALES') AND
                        users.is_active=1 AND
                        users.is_system=0  AND
                        reports.is_delete=0
                        GROUP By users.id
                        HAVING s < 6  OR s IS NULL;", [
                        ':date_report'  => date('Y-m-d')
                    ])->queryAll();
                    foreach ( $items as $user ) {

                        Yii::getLogger()->log('actionApproveToday: Sending Missed Hours Notification ' .  var_export($user, 1) , Logger::LEVEL_INFO);

                        $mail = \Yii::$app->mailer->compose('missedHoursNotification', [
                            'username'  => $user['first_name'],
                            'hours'     => $user['s']
                        ])
                            ->setFrom(\Yii::$app->params['adminEmail'])
                            ->setTo($user['email'])
                            ->setSubject('Skynix CRM: Missed Hours Notification');

                        $mail->send();

                        if ( $user['s'] > 0 ) {

                            WorkHistory::create(
                                WorkHistory::TYPE_USER_FAILS,
                                $user['id'],
                                \Yii::t('app', '- Reported less then 8 hours - Reported only {hours} hours on {date}', [
                                    'hours' => round($user['s'], 2),
                                    'date'  => date('Y-m-d')
                                ])
                            );

                        } else {

                            WorkHistory::create(
                                WorkHistory::TYPE_USER_FAILS,
                                $user['id'],
                                \Yii::t('app', '- Did not report on {date}', [
                                    'hours' => $user['s']
                                ])
                            );

                        }


                    }

                }
                
                $activeSalesProjects = \Yii::$app->db->createCommand("
                    SELECT p.id, p.name, u.id AS manager_id , u.first_name, u.last_name, u.email FROM project_developers pd
                    LEFT JOIN projects p ON pd.project_id=p.id
                    LEFT JOIN users u ON pd.user_id=u.id
                    WHERE pd.is_sales=1 AND p.status='INPROGRESS';")
                ->queryAll();
                
                if ( count($activeSalesProjects) > 0 ) {
                    $salesManagers = array();
                    foreach ( $activeSalesProjects as $activeSalesProject ) {
                        $reports = \Yii::$app->db->createCommand("
                            SELECT r.*, u.first_name, u.last_name, u.email FROM reports r
                            LEFT JOIN users u ON r.user_id=u.id
                            WHERE r.date_added =:date_added AND r.project_id=:project_id
                            ORDER BY u.id, r.id ASC", [
                                ':date_added'  => date('Y-m-d'),
                                ':project_id'  => $activeSalesProject['id']
                        ])->queryAll();
                        $salesManagers [$activeSalesProject['manager_id']][] = array (
                            'project' => $activeSalesProject,
                            'reports' => $reports
                        );
                    }
                    
                    foreach ( $salesManagers as $salesManagerProjects ) {
                        if (count($salesManagerProjects) > 0) {
                            $htmlBody = 'Hi ' .  $salesManagerProjects[0]['project']['first_name'] . '<br>';
                            $htmlBody .= 'The summary regarding your projects on ' . date('Y-m-d') . ': <br>';
                            $htmlBody .= '<ol>';
                            foreach ($salesManagerProjects as $project) {
                                if (count ($project['reports']) == 0) {
                                    $htmlBody .= '<li>' . $project['project']['name'] . ':</li>' . '<ul><li>No reports</li></ul>';
                                } else {
                                    $htmlBody .= '<li>' . $project['project']['name'] . ':</li>';
                                    $htmlBody .= '<ul>';
                                    foreach ($project['reports'] as $report) {
                                        $htmlBody .= '<li>' . $report['id'] . ' ' . $report['reporter_name'] . ' ' . $report['task'] . ' - ' . $report['hours'] . 'h </li>';
                                    }
                                    $htmlBody .= '</ul>';
                                }
                            }
                            $htmlBody .= '</ol>';
                            
                            $mail = \Yii::$app->mailer->compose()
                            ->setFrom(\Yii::$app->params['adminEmail'])
                            ->setTo($salesManagerProjects[0]['project']['email'])
                            ->setReplyTo(\Yii::$app->params['adminEmail'])
                            ->setSubject(date('Y-m-d') . ' Reports Summary')
                            ->setHtmlBody($htmlBody);                           
                            $mail->send();
                        }                  
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
            $users = User::find()->where(['is_system' => 0])->all();
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
