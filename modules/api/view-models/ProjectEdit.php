<?php
/**
 * Created by Skynix Team
 * Date: 13.04.17
 * Time: 17:04
 */

namespace viewModel;

use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use app\models\Project;

class ProjectEdit extends ViewModelAbstract
{
    /**
     * @var Project
     */
    public $model;

    public function define()
    {
        if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {
            if ($id = Yii::$app->request->get('id')) {

                if ( ($this->model = Project::findOne($id)) && $this->model->is_delete == 0 ) {

                    if ( User::hasPermission([User::ROLE_SALES])) {

                        $this->model->setScenario( Project::SCENARIO_UPDATE_SALES );
                    } else {

                        $this->model->setScenario( Project::SCENARIO_UPDATE_ADMIN );
                    }
                    if ( isset($this->postData['type']) ) {

                        unset($this->postData['type']);

                    }
                    $this->model->setAttributes($this->postData);
                    if (! $this->model->api_key) {
                        $this->model->setRandomApiKey();
                    }

                    if ( $this->validate() ) {

                        $this->model->save();

                        if (! count($this->model->projectEnvironments)) {
                            $this->model->addMasterEnv();
                            $this->model->addStagingEnv();

                            $adminUsers = User::getAdmins();
                            if (count($adminUsers) > 0) {
                                foreach ($adminUsers as $admin) {
                                    Yii::$app->mailer->compose()
                                        ->setFrom([Yii::$app->params['fromEmail'] => 'Clodify Notification'])
                                        ->setTo($admin->email)
                                        ->setSubject($this->model->name . ' environments set up')
                                        ->setHtmlBody(
                                            '<p>Hi, ' . $admin->getFullName() . '</p>'
                                            . '<p>The Project: [' . $this->model->id . '] '
                                            . $this->model->name . ' Environments are ready to use</p>'
                                            . '<p>API Key: ' . $this->model->api_key . '</p>')
                                        ->send();
                                }
                            }
                        }
                    }
                }
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }
    }

}