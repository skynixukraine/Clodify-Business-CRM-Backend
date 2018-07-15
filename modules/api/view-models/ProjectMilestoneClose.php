<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 7/15/18
 * Time: 1:14 PM
 */

namespace viewModel;

use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\Milestone;

/**
 * This changes the status of the Milestone to CLOSED
 * Class ProjectMilestoneClose
 * @package viewModel
 */
class ProjectMilestoneClose extends ViewModelAbstract
{
    public function define()
    {

        if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            /** @var $milestone Milestone */
            if (($milestone = Milestone::find()->where(['project_id' => Yii::$app->request->getQueryParam('id'), 'status' => Milestone::STATUS_NEW])->one())) {

                $milestone->status = Milestone::STATUS_CLOSED;
                $milestone->closed_date = date('Y-m-d');
                if ($this->validate() && $milestone->save()) {
                    $this->setData([]);
                }

            } else {

                $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'Could not find OPENed milestones'));

            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }
}