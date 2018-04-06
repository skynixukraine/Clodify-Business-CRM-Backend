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
        $accessToken = Yii::$app->request->headers->get(Processor::HEADER_ACCESS_TOKEN);
        $userId = ApiAccessToken::findOne(['access_token' => $accessToken ] )->user_id;

        $userAvailable = User::findOne($userId)->is_available;

        if(!$userAvailable){
            // if not was available: update user
            User::updateAll(['is_available' => 1], ['id' => $userId]);

            // then, write to availability_logs
            $availabilityLog = new AvailabilityLog();
            $availabilityLog->user_id = $userId;
            $availabilityLog->date = time();
            $availabilityLog->is_available = 1;
            $availabilityLog->save();
        }
    }
}