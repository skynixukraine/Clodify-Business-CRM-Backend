<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 13.03.17
 * Time: 8:43
 */

namespace viewModel;

use app\modules\api\components\Api\Processor;
use Yii;
use app\models\User;

class UserEdit extends ViewModelAbstract
{
    /* @var User*/
    public $model;

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');
        
        if ( !User::hasPermission([User::ROLE_ADMIN]) ) {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }

        if ( $id && $this->model = $this->model->findOne($id) ) {

            if (isset($this->postData['password'])) {
                $this->postData['xHsluIp'] = $this->postData['password'];
                unset($this->postData['password']);
            }
            $this->model->setAttributes($this->postData);
            $this->model->setScenario('edit-user');
            if ( $this->validate() ) {
                if ( $this->model->xHsluIp ) {

                    $this->model->password = $this->model->xHsluIp;

                }
                $this->model->save();
            }

        } else {

            return $this->addError(Processor::ERROR_PARAM, 'The user does not exist');

        }

    }
}