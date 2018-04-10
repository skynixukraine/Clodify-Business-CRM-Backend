<?php
/**
 * Created by Skynix Team
 * Date: 6.04.18
 * Time: 14:20
 */

namespace viewModel;


use app\models\AvailabilityLog;
use app\models\Project;
use app\models\Report;
use app\models\User;
use app\modules\api\components\Api\Processor;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use Yii;

/**
 * Class ResourceStart
 *
 * @package viewModel
 * @see     https://jira.skynix.co/browse/SCA-127
 * @author  Igor (Skynix)
 */
class ResourceStart extends ViewModelAbstract
{

    public function define()
    {
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_DEV, User::ROLE_SALES, User::ROLE_PM])) {

            // Pickup current Users ID from access token
            $userId = Yii::$app->user->id;

            // Change users→is_available = false
            User::updateAll(['is_available' => 0], ['id' => $userId]);

            $today = date('Y-m-d', time());
            $log = AvailabilityLog::find()->where(['user_id' => $userId])->one();

            $dateWhenAvailableRequestPosted = date('Y-m-d', $log->date);

            // if posted today and is_available=true
            if ($today == $dateWhenAvailableRequestPosted && $log->is_available) {

                // create an automated report for this user
                $hours = round(((time() - $log->date) / 3600), 2);

                $report = new Report();
                $report->project_id = Project::find()->where(['name' => Project::INTERNAL_TASK])->one()->id;
                $report->user_id = $userId;
                $report->task = 'Idle Time - I was waiting for tasks';
                // reports hours can not be less than 0.1
                $report->hours = $hours > 0.11 ? $hours : 0.11;
                $report->date_report = $today;

                if (!$report->save()) {
                    foreach ($report->getErrors() as $param => $errors) {
                        foreach ($errors as $error)
                            $this->addError($param, Yii::t('yii', $error));
                    }
                }
            }

        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('yii', 'You have no permission for this action'));
        }

    }
}
