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
            $directorId = $this->model->director_id;
            $user = User::findOne($directorId);

            if(is_null($user)) {
                return $this->addError(Processor::ERROR_PARAM, 'Cannot find user by director_id');
            }

            $allowed = ['CLIENT', 'ADMIN', 'SALES', 'FIN'];

            if(!in_array($user->role, $allowed)) {
                return $this->addError(Processor::ERROR_PARAM, 'director cannot have this role');
            }


            if($this->validate() && $this->model->save()) {
                $this->setData([
                    'business_id' => $this->model->id
                ]);
                if($this->model->is_default == 1) {
                    Business::updateAll(
                        ['is_default' => 0],
                        'id != :id',
                        [
                            ':id' => $this->model->id
                        ]
                    );
                }
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}
