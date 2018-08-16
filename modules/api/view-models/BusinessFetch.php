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
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {

            $result = [];
            $businessId = Yii::$app->request->getQueryParam('id');
            if (!is_null($businessId)) {

            }


            $businesses = Business::find()->all();
            //print_r($businesses);
            if(!empty($businesses)) {
                foreach( $businesses as $business) {
                    $elem['name'] = $business['name'];
                    $elem['address'] = $business['address'];
                    $elem['is_default'] = $business['is_default'];
                    $elem['director'] = $business->getDirector();
                    $result[] = $elem;
                }
            }

//            echo 2;
//
//            die;
            $this->setData($result);

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'You have no permission for this action'));
        }

    }

}
