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

            if (!User::hasPermission([User::ROLE_FIN]) && !User::hasPermission([User::ROLE_ADMIN]) && $id != Yii::$app->user->id) {
                return $this->addError(Processor::ERROR_PARAM,
                    Yii::t('app', 'You have no permission for this action'));
            }
            //  Each user can edit own profile except of columns: role, salary, official_salary, auth_type
            if ($id == Yii::$app->user->id) {

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
                if (isset($this->postData['tags'])) {
                    $this->model->tags = $this->postData['tags'];
                }
                if (isset($this->postData['about'])) {
                    $this->model->about = $this->postData['about'];
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
            }
            
            // FIN can edit all users only official_salary column
            if (User::hasPermission([User::ROLE_FIN])) {
                if (isset($this->postData['official_salary'])) {
                    $this->model->official_salary = $this->postData['official_salary'];
                }
            }

            if (isset($this->postData['password'])) {
                $this->postData['xHsluIp'] = $this->postData['password'];
                unset($this->postData['password']);
            }

            // Admin can edit all users all columns
            if (User::hasPermission([User::ROLE_ADMIN])) {
                $this->model->setAttributes($this->postData);
            }

            $this->model->setScenario(User::SCENARIO_UPDATE_USER);

            if ($this->validate()) {
                if ($this->model->xHsluIp) {

                    $this->model->password = $this->model->xHsluIp;

                }
                $this->model->save();
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, 'The user does not exist');
        }
    }
}