<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 20.08.18
 * Time: 16:01
 */

namespace viewModel;
use Yii;
use app\models\EmailTemplate;
use app\models\User;
use app\modules\api\components\Api\Processor;

class EmailTemplateUpdate extends ViewModelAbstract
{
    public function define(){
        if(User::hasPermission([User::ROLE_ADMIN])) {
            $emailTemplateId = Yii::$app->request->getQueryParam('id');
            $emailTemplate = EmailTemplate::findOne($emailTemplateId);

            if(is_null($emailTemplate)){
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','email template is\'t found by Id'));
            }

            $requiredFields = [
                'subject',
                'reply_to',
                'body'
            ];

            $data = $this->postData;

            $checkRequiredFields = true;
            $missedField = '';

            if(is_null($data))
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','missed required field all'));

            foreach ($requiredFields as $requiredField) {
                if(!array_key_exists($requiredField, $data)){
                    $checkRequiredFields = false;
                    $missedField = $requiredField;
                }

            }

            if(!$checkRequiredFields) {
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','missed required field ' . $missedField));
            }

            $emailTemplate->subject = $data['subject'];
            $emailTemplate->reply_to = $data['reply_to'];
            $emailTemplate->body = $data['body'];

            if($this->validate()) {
                $emailTemplate->save();
                $this->setData([
                    'subject' => $emailTemplate->subject,
                    'reply_to' => $emailTemplate->reply_to,
                    'body' => $emailTemplate->body,
                ]);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}