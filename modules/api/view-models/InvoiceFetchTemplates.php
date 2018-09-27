<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 08.11.18
 * Time: 11:50
 */

namespace viewModel;

use app\models\InvoiceTemplate;
use Yii;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class InvoiceTemplateFetch
 * @see     https://jira.skynix.company/browse/SCA-245
 * @package viewModel
 */
class InvoiceFetchTemplates extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {

            $result = [];
            $invoiceTemplateId = Yii::$app->request->getQueryParam('id');
            if (!is_null($invoiceTemplateId)) {

                $invoiceTemplate = InvoiceTemplate::findOne($invoiceTemplateId);
                if(is_null($invoiceTemplate)){
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'invoice template was not found by id'));
                }

                $result[] = $this->defaultVal($invoiceTemplate);
                return $this->setData($result);
            }

            $invoiceTemplates = InvoiceTemplate::find()->all();

            if(!empty($invoiceTemplates)) {
                foreach( $invoiceTemplates as $invoiceTemplate) {
                    $result[] = $this->defaultVal($invoiceTemplate);
                }
            }

            $this->setData($result);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

    /**
     * Does the result structure from the model
     *
     * @param \yii\db\ActiveRecord $model
     * @return array the array structure to return by method
     */
    private function defaultVal($model)
    {
        $list['id'] = $model->id;
        $list['name'] = $model->name;
        $list['body'] = $model->body;
        $list['variables'] = $model->variables;
        return $list;
    }

}
