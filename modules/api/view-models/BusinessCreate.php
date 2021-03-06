<?php
/**
 *  Created by SkynixTeam.
 *  User: Oleg
 *  Date: 15.08.17
 *  Time: 13:24
 */

namespace viewModel;

use Yii;
use app\models\Business;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 *  Class BusinessCreate
 *  @see https://jira.skynix.co/browse/SCA-232
 *  @package viewModel
 */
class BusinessCreate extends ViewModelAbstract
{
    public function define() {

        if (User::hasPermission([User::ROLE_ADMIN])) {
            $this->model->load(Yii::$app->request->post());

            if($this->validate() && $this->model->save()) {
                $this->setData([
                    'business_id' => $this->model->id
                ]);
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}
