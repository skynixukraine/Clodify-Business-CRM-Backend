<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/7/18
 * Time: 2:10 PM
 */
namespace viewModel;

use app\models\CoreClient;
use app\modules\api\models\ApiAccessToken;
use Yii;
use app\models\User;
use app\modules\api\models\ApiLoginForm;
use app\modules\api\components\Api\Processor;
use app\models\EmailTemplate;


class ClientRegistration extends ViewModelAbstract
{
    /**
     * @var CoreClient
     */
    protected $model;

    public function define()
    {


        if( $this->validate() ) {

            $this->model->setScenario( CoreClient::SCENARIO_REGISTER_VALIDATION );
            $this->model->domain = $this->model->getConvertedDomain();
            $this->model->mysql_user      = Yii::$app->params['databasePrefix'] . "user_" . $this->model->getConvertedDomain();
            $this->model->mysql_password  = Yii::$app->security->generateRandomString( 12 );

            if ( $this->validate() && $this->model->save() ) {

                $emailTemplate = EmailTemplate::findOne(['subject' => 'Skynix CRM configuration']);


                $mail = Yii::$app->mailer->compose($emailTemplate, [
                    'username' => $this->model->first_name,
                    'link_to_crm' => '',
                    'domain' => $this->model->domain,
                    'email' => $this->model->email,
                    'auto_generated_password' => $this->model->mysql_password,

                ])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($this->model->email)
                    ->setSubject('Skynix CRM: client registration');

                if (!$mail->send()) {
                    $this->addError('email', "Skynix CRM configuration");
                }

                $this->setData([
                    'client_id' => $this->model->id
                ]);

            }
        }

    }
}