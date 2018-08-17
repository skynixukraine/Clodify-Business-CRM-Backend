<?php
/**
 * Created by SkynixTeam.
 * User: igor
 * Date: 08.11.17
 * Time: 11:50
 */

namespace viewModel;

use app\models\Business;
use Yii;
use app\models\User;
use app\modules\api\components\Api\Processor;

/**
 * Class BusinessFetch
 * @see     https://jira.skynix.company/browse/SCA-54
 * @package viewModel
 */
class BusinessFetch extends ViewModelAbstract
{
    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN])) {

            $result = [];
            $businessId = Yii::$app->request->getQueryParam('id');
            if (!is_null($businessId)) {

                $business = Business::findOne($businessId);
                if(is_null($business)){
                    return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'business was not found by id'));
                }

                $result[] = $this->defaultVal($business);
                return $this->setData($result);
            }

            $businesses = Business::find()->all();

            if(!empty($businesses)) {
                foreach( $businesses as $business) {
                    $result[] = $this->defaultVal($business);
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
        $list['name'] = $model->name;
        $list['address'] = $model->address;
        $list['is_default'] = $model->is_default;
        $list['director'] = $model->director;
        return $list;
    }

}
