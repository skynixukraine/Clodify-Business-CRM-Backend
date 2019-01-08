<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 7/15/18
 * Time: 11:50 AM
 */

namespace viewModel;

use Yii;
use app\components\DateUtil;
use app\models\Milestone;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * This creates a new milestone
 * Class ProjectMilestoneCreate
 * @package viewModel
 */
class ProjectMilestoneCreate extends ViewModelAbstract
{
    /**
     * @var Milestone
     */
    protected $model;

    public function define()
    {
        if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {

            $this->model->start_date    = DateUtil::convertData( $this->model->start_date );
            $this->model->end_date      = DateUtil::convertData( $this->model->end_date );
            $this->model->project_id    = \Yii::$app->request->getQueryParam('id');
            $this->model->status        = Milestone::STATUS_NEW;

            if($this->validate() &&  $this->model->save()){
                $this->setData([
                    'milestone_id'=> $this->model->id
                ]);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }
    }
}