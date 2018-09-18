<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 20.08.18
 * Time: 16:01
 */

namespace viewModel;
use Yii;
use app\models\InvoiceTemplate;
use app\models\User;
use app\modules\api\components\Api\Processor;

class InvoiceUpdateTemplates extends ViewModelAbstract
{
    public function define(){
        if(User::hasPermission([User::ROLE_ADMIN])) {
            $invoiceTemplateId = Yii::$app->request->getQueryParam('id');
            $invoiceTemplate = InvoiceTemplate::findOne($invoiceTemplateId);

            if(is_null($invoiceTemplate)){
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','invoice template is\'t found by Id'));
            }

            $requiredFields = [
                'name',
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

            $invoiceTemplate->name = $data['name'];
            $invoiceTemplate->body = $data['body'];

            if($this->validate()) {
                $invoiceTemplate->save();
                $this->setData([
                    'name' => $invoiceTemplate->name,
                    'body' => $invoiceTemplate->body
                ]);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}