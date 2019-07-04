<?php
/**
 * Created by Skynix Team
 * Date: 15.03.17
 * Time: 10:54
 */

namespace viewModel;

use app\models\Project;
use app\models\User;
use app\models\ProjectDeveloper;
use app\models\ProjectCustomer;
use app\modules\api\components\Api\Processor;
use Yii;


/**
 * Create new project. Name, customers, invoice_received,
 * developers, is_pm, is_sales params are required
 * Class ProjectCreate
 * @package viewModel
 */
class ProjectCreate extends ViewModelAbstract
{
    public function define()
    {              
        if ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES])) {
            $this->model->status = Project::STATUS_NEW;
            if (! $this->model->api_key) {
                $this->model->setRandomApiKey();
            }

            if($this->validate() &&  $this->model->save()) {
                if ( User::hasPermission([User::ROLE_SALES ]) ) {
                    $salesUser = User::findOne([
                        'is_delete' => 0,
                        'is_active' => 1,
                        'id' => Yii::$app->user->id
                    ]);
                    
                    $customers = \Yii::$app->db->createCommand("
                    SELECT u.first_name, u.last_name FROM " . ProjectCustomer::tableName() . " pc
                    LEFT JOIN " . User::tableName() . " u ON pc.user_id=u.id
                    WHERE pc.project_id=:project_id
                    ORDER BY u.id ASC", [
                        ':project_id'  => $this->model->id
                    ])->queryAll();
                    if (count($customers) > 0) {
                        $customersData = array();
                        foreach ($customers as $customer) {
                            $customersData [] = $customer['first_name'] . ' ' . $customer['last_name'];
                        }
                    }
                    $customers = (count($customersData)>0) ? implode(", ", $customersData) : '';
                    
                    $developers = \Yii::$app->db->createCommand("
                    SELECT u.first_name, u.last_name FROM " . ProjectDeveloper::tableName() . " pd
                    LEFT JOIN " . User::tableName() . " u ON pd.user_id=u.id
                    WHERE pd.project_id=:project_id
                    ORDER BY u.id ASC", [
                        ':project_id'  => $this->model->id
                    ])->queryAll();
                    if (count($developers) > 0) {
                        $developerData = array();
                        foreach ($developers as $developer) {
                            $developerData [] = $developer['first_name'] . ' ' . $developer['last_name'];
                        }
                    }
                    $developers = (count($developerData)>0) ? implode(", ", $developerData) : '';
                    $adminUsers = User::getAdmins();

                    if (count($adminUsers) > 0) {
                        foreach ($adminUsers as $admin) {
                            Yii::$app->mail->send('create_project', [
                                $admin->email
                            ], [
                                'AdminFirstName' => $admin['first_name'],
                                'SalesFirstName' => $salesUser->first_name,
                                'ProjectName' => $this->model->name,
                                'ProjectDateStart' => $this->model->date_start,
                                'ProjectDateEnd' => $this->model->date_end,
                                'ProjectCustomers' => $customers,
                                'ProjectDevelopers' => $developers,
                                'SalesEmail' => $salesUser->email
                            ]);
                        }
                    }                  
                }

                if (! count($this->model->projectEnvironments)) {
                    $this->model->addMasterEnv();
                    $this->model->addStagingEnv();

                    $adminUsers = $adminUsers ?? User::getAdmins();
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

                $this->setData([
                    'project_id'=> $this->model->id
                ]);
            }
        }  else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }
    }
}