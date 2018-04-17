<?php
/**
 * Created by Skynix Team
 * Date: 13.03.17
 * Time: 8:43
 */
namespace viewModel;

use app\modules\api\components\Api\Processor;
use Yii;
use app\models\User;

/**
 * see https://jira.skynix.co/browse/SCA-141
 * Class UserEdit
 * @package viewModel
 */
class UserEdit extends ViewModelAbstract
{
    /* @var User*/
    public $model;

    public function define()
    {
        $id = Yii::$app->request->getQueryParam('id');

        if ($id && $this->model = $this->model->findOne($id)) {

            // Admin can edit all users all columns
            if (User::hasPermission([User::ROLE_ADMIN])) {

                if (isset($this->postData['password'])) {
                    $this->postData['xHsluIp'] = $this->postData['password'];
                    unset($this->postData['password']);
                }

                $this->model->setScenario(User::SCENARIO_UPDATE_USER);
                $this->model->setAttributes($this->postData);

                if ($this->validate()) {
                    if ($this->model->xHsluIp) {

                        $this->model->password = $this->model->xHsluIp;

                    }
                    $this->model->save();
                }

                //  Each user can edit own profile except of columns: role, salary, official_salary, auth_type
            } elseif ($id == Yii::$app->user->id) {

                if (isset($this->postData['first_name'])) {
                    $this->model->first_name = $this->postData['first_name'];
                }
                if (isset($this->postData['last_name'])) {
                    $this->model->last_name = $this->postData['last_name'];
                }
                if (isset($this->postData['middle_name'])) {
                    $this->model->middle_name = $this->postData['middle_name'];
                }
                if (isset($this->postData['email'])) {
                    $this->model->email = $this->postData['email'];
                }
                if (isset($this->postData['company'])) {
                    $this->model->company = $this->postData['company'];
                }
                if (isset($this->postData['phone'])) {
                    $this->model->phone = $this->postData['phone'];
                }
                if (isset($this->postData['password'])) {
                    $this->postData['xHsluIp'] = $this->postData['password'];
                    unset($this->postData['password']);
                }
                $this->model->setScenario(User::SCENARIO_UPDATE_USER);
                if ($this->validate()) {
                    if ($this->model->xHsluIp) {
                        $this->model->password = $this->model->xHsluIp;
                    }
                    $this->model->save();
                }

             // FIN can edit all users only official_salary column
            } elseif (User::hasPermission([User::ROLE_FIN])){
                if (isset($this->postData['official_salary'])) {
                    $this->model->official_salary = $this->postData['official_salary'];
                }
                $this->model->setScenario(User::SCENARIO_UPDATE_USER);
                if ($this->validate()) {
                    $this->model->save();
                }
            } else {
                return $this->addError(Processor::ERROR_PARAM,
                Yii::t('yii', 'You have no permission for this action'));
            }
        } else {
            return $this->addError(Processor::ERROR_PARAM, 'The user does not exist');
        }

    }
}