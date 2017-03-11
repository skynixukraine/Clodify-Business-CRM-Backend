<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 11.03.17
 * Time: 16:28
 */

namespace viewModel;

use app\models\User;
use app\modules\api\components\Api\Processor;
use Yii;
use app\components\DateUtil;
use yii\helpers\Url;

class UserView extends ViewModelAbstract
{
    /** @var  \app\models\User */
    public $model;

    public function define()
    {
        $userId = Yii::$app->request->getQueryParam('id');
        if (($model = $this->model->findOne($userId)) &&  self::hasPermission($userId)) {
            $data = [
                'first_name'   => $model->first_name,
                'last_name'    => $model->last_name,
                'middle_name'  => $model->middle_name,
                'company'      => $model->company,
                'tags'         => $model->tags,
                'about'        => $model->about
                ];

            if (User::hasPermission([User::ROLE_ADMIN])) {
                $data['month_logged_hours'] = $model->month_logged_hours;
                $data['year_logged_hours']  = $model->year_logged_hours;
                $data['total_logged_hours'] = $model->total_logged_hours;
                $data['month_paid_hours']   = $model->month_paid_hours;
                $data['year_paid_hours']    = $model->year_paid_hours;
                $data['total_paid_hours']   = $model->total_paid_hours;
            }

            $data['photo'] = $model->photo ? urldecode(Url::to(['/cp/index/getphoto', 'entry' => Yii::getAlias('@app') .
                '/data/' . $model->id . '/photo/' . $model->photo])) : "/img/avatar.png";
            $data['sign'] = $model->sing;
            $data['bank_account_en'] = strip_tags($model->bank_account_en);
            $data['bank_account_ua'] = strip_tags($model->bank_account_ua);

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
            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {

                $data['salary'] = '$' . $model->salary;
                $data['salary_up'] = $model->date_salary_up ? DateUtil:: convertDateTimeWithoutHours($model->date_salary_up) : 'No changes';
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

            $data = User::find()
                ->where(['is_delete' => 0])
                ->all();
        }
        //FIN and SALES can see all active users (except of themselves)
        elseif(User::hasPermission([User::ROLE_FIN, User::ROLE_SALES])) {
            $data = User::find()->where(['is_active' => 1, 'is_delete' => 0])
                ->andWhere(['<>', 'id', Yii::$app->user->identity->getId()])
                ->all();
        }

        //PM & DEV can see only active users with roles DEV, SALES, PM, ADMIN, FIN except of themselves
        elseif( User::hasPermission([User::ROLE_DEV, User::ROLE_PM])) {
            $data = User::find()->where(['is_active' => 1, 'is_delete' => 0])
                ->andWhere(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_PM, User::ROLE_ADMIN, User::ROLE_FIN]])
                ->andWhere(['<>', 'id', Yii::$app->user->identity->getId()])
                ->all();
        }
        //CLIENT can see only active users with roles DEV, SALES, PM, ADMIN
        elseif( User::hasPermission([User::ROLE_CLIENT])) {
            $workers = \app\models\ProjectCustomer::allClientWorkers(Yii::$app->user->id);
            $arrayWorkers = [];
            foreach($workers as $worker){
                $arrayWorkers[]= $worker->user_id;
            }
            $devUser = '';
            if(!empty($arrayWorkers)) {
                $devUser = implode(', ' , $arrayWorkers);
            }
            else{
                $devUser = 'null';
            }

            $data = User::find()
                ->where(User::tableName() . '.id IN (' . $devUser . ')')
                ->andWhere(['is_active' => 1, 'is_delete' => 0])
                ->andWhere(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_PM, User::ROLE_ADMIN]])
                ->all();
        }

        $availableUsers = [];
        foreach ($data as $user) {
            $availableUsers[] = $user->id;
        }


        if (in_array($userId, $availableUsers)) {
            return true;
        }

    }

}