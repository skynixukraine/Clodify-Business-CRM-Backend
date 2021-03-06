<?php
/**
 * Created by Skynix Team
 * Date: 11.03.17
 * Time: 16:28
 */

namespace viewModel;

use app\models\ProjectCustomer;
use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use app\components\DateUtil;
use yii\helpers\Url;
use yii\log\Logger;

/**
 * View single user data
 * Class UserView
 * @package viewModel
 */
class UserView extends ViewModelAbstract
{
    /** @var  \app\models\User */
    public $model;

    public function define()
    {
        $userId = (int)Yii::$app->request->getQueryParam('id');

        if (($model = $this->model->findOne($userId)) &&  self::hasPermission($userId)) {

            if ($model->is_delete == 1) {
                return $this->addError(Processor::ERROR_PARAM, 'Hey, you are looking for the deleted user. The access completely impossible.');
            }

            $data = [
                'first_name'                => $model->first_name,
                'last_name'                 => $model->last_name,
                'middle_name'               => $model->middle_name,
                'company'                   => $model->company,
                'tags'                      => $model->tags,
                'about'                     => $model->about
                ];

            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ||
                (Yii::$app->user->id === $userId)) {
                $data['month_logged_hours'] = $model->month_logged_hours;
                $data['year_logged_hours']  = $model->year_logged_hours;
                $data['total_logged_hours'] = $model->total_logged_hours;
                $data['month_paid_hours']   = $model->month_paid_hours;
                $data['year_paid_hours']    = $model->year_paid_hours;
                $data['total_paid_hours']   = $model->total_paid_hours;
                $data['auth_type']          = $model->auth_type;
            }

            $data['photo'] = $model->photo ? urldecode(Url::to(['/cp/index/getphoto', 'entry' => Yii::getAlias('@app') .
                '/data/' . $model->id . '/photo/' . $model->photo])) : "/img/avatar.png";
            $data['sign'] = $model->sing;
            $data['bank_account_en'] = $model->bank_account_en;
            $data['bank_account_ua'] = $model->bank_account_ua;

            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
                $data  ['role'] = $model->role;
            }

            $data['email'] = $model->email;
            $data['phone'] = $model->phone;

            if (User::hasPermission([User::ROLE_ADMIN])) {
                $data['last_login'] = $model->date_login ? DateUtil::convertDatetimeWithoutSecund($model->date_login) : "The user didn't login";
                $data['joined'] = DateUtil::convertDateTimeWithoutHours($model->date_signup);
                $data['is_active'] = $model->is_active;
            }

            Yii::getLogger()->log('UserView RealID: ' . Yii::$app->user->id . ' PARAM: '.$userId, Logger::LEVEL_INFO);
            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ||
                (Yii::$app->user->id === $userId)) {

                $data['salary']                     = $model->salary;
                $data['official_salary']            = $model->official_salary;
                $data['salary_up']                  = $model->date_salary_up ? DateUtil:: convertDateTimeWithoutHours($model->date_salary_up) : null;
                $data['vacation_days']              = $model->vacation_days;
                $data['vacation_days_available']    = $model->vacation_days_available;
            }

            $this->setData($data);

        } else {
            return $this->addError(Processor::ERROR_PARAM, "You do not have permission to view this user data");
        }

    }

    // check if current user has permission to view requested user page($userId)
    public static function hasPermission($userId)
    {
        //Admin can see all users (active & suspended)
        if( User::hasPermission([User::ROLE_ADMIN])) {
            return true;
        }
        //FIN and SALES can see all active users (except of themselves)
        elseif(User::hasPermission([User::ROLE_FIN, User::ROLE_SALES])) {

            if (User::find()->where(['is_active' => 1, 'is_delete' => 0, 'id' => $userId])->count()) {
                return true;
            }

        }
        //PM & DEV can see only active users with roles DEV, SALES, PM, ADMIN, FIN except of themselves
        elseif( User::hasPermission([User::ROLE_DEV, User::ROLE_PM])) {

            if (User::find()->where(['is_active' => 1, 'is_delete' => 0, 'id' => $userId])
                ->andWhere(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_PM, User::ROLE_ADMIN, User::ROLE_FIN]])
                ->count()) {
                return true;
            }

        }
        //CLIENT can see only active users with roles DEV, SALES, PM, ADMIN and info about themselves
        elseif( User::hasPermission([User::ROLE_CLIENT])) {

            if($userId == Yii::$app->user->id){return true;}

            $workers = ProjectCustomer::allClientWorkers(Yii::$app->user->id);
            foreach($workers as $worker){

                if ( $worker->user_id == $userId && User::find()
                        ->where([User::tableName() . '.id' => $userId, 'is_active' => 1, 'is_delete' => 0])
                        ->andWhere(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_PM, User::ROLE_ADMIN]])
                        ->count()) {
                    return true;
                }

            }



        }

        return false;

    }

}