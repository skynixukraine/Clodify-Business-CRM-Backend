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

class BusinessUpdate extends ViewModelAbstract
{
    public function define(){
        if(User::hasPermission([User::ROLE_ADMIN])) {
            $businessId = Yii::$app->request->getQueryParam('id');
            $business = Business::findOne($businessId);

            if(is_null($business)){
                return $this->addError(Processor::ERROR_PARAM, Yii::t('app','business is\'t found by Id'));
            }

            $requiredFields = [
                'name',
                'director_id',
                'address',
                'is_default'
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

            $business->name = $data['name'];
            $business->director_id = $data['director_id'];
            $business->address = $data['address'];
            $business->is_default = $data['is_default'];

            if($this->validate()) {
                $business->save();
                $this->setData([
                    'name' => $business->name,
                    'director_id' => $business->director_id,
                    'address' => $business->address,
                    'is_default' => $business->is_default
                ]);
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, 'You have no permission for this action');
        }
    }
}