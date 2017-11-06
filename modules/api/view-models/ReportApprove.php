<?php

/**
 * Created by Skynix Team.
 * User: igor
 * Date: 03.11.17
 * Time: 9:38
 */

namespace viewModel;

use app\models\Report;
use app\models\ReportAction;
use app\models\User;
use app\models\ProjectDeveloper;
use app\modules\api\components\Api\Processor;
use Yii;

/**
 * Class ReportApprove
 *
 * @package viewModel
 * @see     https://jira.skynix.company/browse/SCA-34
 * @author  Igor (Skynix)
 */
class ReportApprove extends ViewModelAbstract
{

    public function define()
    {

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN])) {
            $id = Yii::$app->request->getQueryParam('id');
            $curReport = Report::findOne($id);
            if ($curReport) {
                if (!$curReport->is_approved) {

                    if (User::hasPermission([User::ROLE_ADMIN])) {
                        $this->noteToActionTable($curReport);
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
                                    $this->noteToActionTable($curReport);
                                } else {
                                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You (role sales) can not approve own report'));
                                }
                            } else {
                                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for approving this report '));
                            }
                        }
                    }

                    if (User::hasPermission([User::ROLE_FIN])) {
                        $finId = Yii::$app->user->id;
                        if($curReport->user_id != $finId){
                            $this->noteToActionTable($curReport);
                        } else {
                            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You (role fin) can not approve own report'));
                        }
                    }
                } else {
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You are trying to approve already approved report'));
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You are trying to approve not existent report'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }

    public function noteToActionTable($curReport)
    {
        $approverRole = Yii::$app->user->identity->role;
        $approverName = User::getUserFirstName();
        $reportsHours = $curReport->hours;
        $reporterName = User::getUserFirstNameById($curReport->user_id);
        $reporterRole = User::getUserRoleById($curReport->user_id);

        $str = $approverRole . ' ' . $approverName . ' has approved ' .
            $reportsHours . ' hours of ' . $reporterRole . ' ' . $reporterName;
        $action = new ReportAction();
        $action->report_id = Yii::$app->request->getQueryParam('id');
        $action->user_id = Yii::$app->user->identity->getId();
        $action->action = $str;
        $action->datetime = time();
        $action->save();

        $curReport->is_approved = 1;
        $curReport->save(false);
    }

}