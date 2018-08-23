<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 08.11.18
 * Time: 11:50
 */

namespace viewModel;

use app\models\EmailTemplate;
use Yii;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class EmailTemplateFetch
 * @see     https://jira.skynix.company/browse/SCA-240
 * @package viewModel
 */
class EmailTemplateFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {

            $result = [];
            $emailTemplateId = Yii::$app->request->getQueryParam('id');
            if (!is_null($emailTemplateId)) {

                $emailTemplate = EmailTemplate::findOne($emailTemplateId);
                if(is_null($emailTemplate)){
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'email template was not found by id'));
                }

                $result[] = $this->defaultVal($emailTemplate);
                return $this->setData($result);
            }

            $emailTemplates = EmailTemplate::find()->all();

            if(!empty($emailTemplates)) {
                foreach( $emailTemplates as $emailTemplate) {
                    $result[] = $this->defaultVal($emailTemplate);
                }
            }

            $this->setData($result);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

    private function defaultVal($model)
    {
        $list['id'] = $model->id;
        $list['subject'] = $model->subject;
        $list['reply_to'] = $model->reply_to;
        $list['body'] = $model->body;
        return $list;
    }

}
