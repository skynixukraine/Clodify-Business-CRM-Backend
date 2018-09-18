<?php
/**
 * Created by SkynixTeam.
 * User: Oleg
 * Date: 20.08.18
 * Time: 16:01
 */

namespace viewModel;
use Yii;
use app\models\Business;
use app\models\User;
use app\modules\api\components\Api\Processor;

class BusinessUploadLogo extends ViewModelAbstract
{
    public function define(){

        if(User::hasPermission([User::ROLE_ADMIN])) {

            $businessId = Yii::$app->request->getQueryParam('id');
            $business = Business::findOne($businessId);

            if(is_null($business)){
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','business is\'t found by Id'));
            }

            if(!isset($this->postData['logo'])){
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','logo data missed'));
            }


            $result = Business::uploadLogo($this->postData['logo'], $businessId);
            if ($result['ObjectURL']) {
                $this->setData(['logo' => $result['ObjectURL']]);
            } else {
                $this->addError('logo', 'Sorry, by some reason we could not upload your logo, try again later.');
            }


        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}