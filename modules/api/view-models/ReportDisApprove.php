<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 06.11.17
 * Time: 12:07
 */

namespace viewModel;

use app\models\Report;
use app\models\ReportAction;
use app\models\User;
use app\models\ProjectDeveloper;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class ReportDisapprove
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-35
 * @author  Igor (Skynix)
 */
class ReportDisApprove extends ViewModelAbstract
{

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN])) {
            $id = Yii::$app->request->getQueryParam('id');
            $curReport = Report::findOne($id);
            if ($curReport) {
                if ($curReport->is_approved) {

                    if(isset($this->postData['hours'])){
                        $hoursToDisapprove = $this->postData['hours'];
                    } else {
                        $hoursToDisapprove = 0;
                    }

                    if($hoursToDisapprove > $curReport->hours) {
                        return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Sorry, you can not disapprove more hours than were reported'));
                    }


                    if (User::hasPermission([User::ROLE_ADMIN])) {
                        $this->disapproveReport($curReport, $hoursToDisapprove);
                    }
                    // $this->postData['hours']
                    if (User::hasPermission([User::ROLE_SALES])) {
                        $salesId = Yii::$app->user->id;

                        if($salesId && $salesId != null){

                            $projectsDeveloper = ProjectDeveloper::getReportsOfSales($salesId );
                            $projectId = [];
                            foreach($projectsDeveloper as $project){
                                $projectId[] = $project->project_id;
                            }
                            if(in_array($curReport->project_id, $projectId)){
                                if($curReport->user_id != $salesId) {
                                    $this->disapproveReport($curReport, $hoursToDisapprove);
                                } else {
                                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You (role sales) can not disapprove own report'));
                                }
                            } else {
                                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for disapproving this report '));
                            }
                        }
                    }

                    if (User::hasPermission([User::ROLE_FIN])) {
                        $finId = Yii::$app->user->id;
                        if($curReport->user_id != $finId){
                            $this->disapproveReport($curReport, $hoursToDisapprove);
                        } else {
                            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You (role fin) can not disapprove own report'));
                        }
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to disapprove already disapproved report'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You are trying to disapprove not existent report'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }


    public function disapproveReport($report, $hoursToDisapprove){
        if($hoursToDisapprove < $report->hours && $hoursToDisapprove != 0) {
            $clone = new Report;
            $clone->attributes = $report->attributes;
            $clone->hours = $hoursToDisapprove;
            $cloneCost = $hoursToDisapprove * ($report->cost/$report->hours);
            $clone->cost = $cloneCost;
            $clone->save();
            $this->noteToActionTableForDisapproving($clone);
            $this->sendEmailToReportOwner($clone);
            $report->hours = $report->hours - $hoursToDisapprove;
            $report->cost = $report->cost - $cloneCost;
            $report->save(false);
        } else if($hoursToDisapprove == $report->hours || $hoursToDisapprove == 0) {
            $this->noteToActionTableForDisapproving($report);
            $this->sendEmailToReportOwner($report);
        }
    }

    public function noteToActionTableForDisapproving($curReport)
    {
        $approverRole = Yii::$app->user->identity->role;
        $approverName = User::getUserFirstName();
        $reportsHours = $curReport->hours;
        $reporterName = User::getUserFirstNameById($curReport->user_id);
        $reporterRole = User::getUserRoleById($curReport->user_id);

        $str = $approverRole . ' ' . $approverName . '  has disapproved  ' .
            $reportsHours . ' hours of ' . $reporterRole . ' ' . $reporterName;
        $action = new ReportAction();
        $action->report_id = Yii::$app->request->getQueryParam('id');
        $action->user_id = Yii::$app->user->identity->getId();
        $action->action = $str;
        $action->datetime = time();
        $action->save();

        $curReport->is_approved = 0;
        $curReport->save(false);
    }
    
    public function sendEmailToReportOwner ($curReport)
    {
        $owner = User::findOne([
            'is_delete' => 0,
            'id' => $curReport->user_id,
        ]);
        $approver = User::findOne([
            'is_delete' => 0,
            'id' => Yii::$app->user->identity->getId()
        ]);
        if ($owner) {
            Yii::$app->mail->send('disapprove_report', [
                $owner->email => $owner->getFullName()
            ], [
                'FirstName' => $approver->first_name,
                'LastName' => $approver->last_name,
                'ReportID' => $curReport->id,
                'OwnerFirstName' => $owner->first_name,
                'ReportDate' => $curReport->date_report,
                'ReportProject' => $curReport->getProject()->one()->name,
                'ReportText' => $curReport->task,
                'ReportHours' => $curReport->hours,
                'ApproverEmail' => $approver->email,
            ]);
        }
    }

}