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

                    if (User::hasPermission([User::ROLE_ADMIN])) {
                        $this->noteToActionTableForDisapproving($curReport);
                    }

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
                                    $this->noteToActionTableForDisapproving($curReport);
                                } else {
                                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You (role sales) can not disapprove own report'));
                                }
                            } else {
                                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for disapproving this report '));
                            }
                        }
                    }

                    if (User::hasPermission([User::ROLE_FIN])) {
                        $finId = Yii::$app->user->id;
                        if($curReport->user_id != $finId){
                            $this->noteToActionTableForDisapproving($curReport);
                        } else {
                            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You (role fin) can not disapprove own report'));
                        }
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You are trying to disapprove already disapproved report'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You are trying to approve not existent report'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
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

}