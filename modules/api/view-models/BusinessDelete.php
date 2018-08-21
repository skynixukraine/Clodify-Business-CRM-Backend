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

class BusinessDelete extends ViewModelAbstract
{
    public function define(){
        if(User::hasPermission([User::ROLE_ADMIN])) {
            $businessId = Yii::$app->request->getQueryParam('id');
            $business = Business::findOne($businessId);

            if(is_null($business)){
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','business is\'t found by Id'));
            }

            $business->is_delete = 1;
            $this->model = $business;

            if($this->validate()) {
                $business->save();
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}