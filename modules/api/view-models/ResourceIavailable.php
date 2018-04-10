<?php
/**
 * Created by Skynix Team
 * Date: 6.04.18
 * Time: 12:00
 */

namespace viewModel;


use app\models\AvailabilityLog;
use app\models\User;
use app\modules\api\components\Api\Processor;
use app\modules\api\models\ApiAccessToken;
use Yii;

/**
 * Class ResourceIavailable
 *
 * @package viewModel
 * @see     https://jira.skynix.co/browse/SCA-126
 * @author  Igor (Skynix)
 */
class ResourceIavailable extends ViewModelAbstract
{

    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_DEV, User::ROLE_SALES, User::ROLE_PM])) {

            $userId = Yii::$app->user->id;

            User::updateAll(['is_available' => 1], ['id' => $userId]);

            $availabilityLog = new AvailabilityLog();
            $availabilityLog->user_id = $userId;
            $availabilityLog->date = time();
            $availabilityLog->is_available = 1;
            $availabilityLog->save();

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }
    }
}