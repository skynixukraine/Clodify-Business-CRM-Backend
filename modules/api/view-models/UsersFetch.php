<?php
/**
 * Created by Skynix Team
 * Date: 06.03.17
 * Time: 15:35
 */

namespace viewModel;

use Yii;
use app\models\User;
use app\components\DataTable;
use app\components\DateUtil;
use yii\helpers\Url;
use app\modules\api\components\SortHelper;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\Project;

class UsersFetch extends ViewModelAbstract
{
    public function define()
    {

        $order       = Yii::$app->request->getQueryParam('order', []);
        $keyword     = Yii::$app->request->getQueryParam('search_query');
        $role		 = Yii::$app->request->getQueryParam("role");
        $active		 = Yii::$app->request->getQueryParam("is_active");
        $start       = Yii::$app->request->getQueryParam('start') ? Yii::$app->request->getQueryParam('start') : 0;
        $limit       = Yii::$app->request->getQueryParam('limit') ? Yii::$app->request->getQueryParam('limit') : SortHelper::DEFAULT_LIMIT;

        //Admin can see all users (active & suspended)
        if( User::hasPermission([User::ROLE_ADMIN])) {

            $query = User::find();
        }

        //FIN has an access to all active users of roles DEV, SALES, FIN, ADMIN to all columns
        if(User::hasPermission([User::ROLE_FIN])) {
            $query = User::find()->where(['is_active' => 1])
                ->andWhere(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_ADMIN, User::ROLE_FIN]]);
        }

        //SALES has an access to all active users who are DEV, ADMIN
        // and has an access to CLIENT users of their projects and has
        // an access to all columns except of salary, official_salary, salary_up
        if( User::hasPermission([User::ROLE_SALES])) {
            $workers = User::getCustomersForSales();
            $arrayWorkers = [];
            foreach($workers as $worker){
                $arrayWorkers[] = $worker->id;
            }
            if(!empty($arrayWorkers)) {
                $devUser = implode(', ' , $arrayWorkers);
            } else {
                $devUser = 'null';
            }

            $query1 = User::find()
                ->where(User::tableName() . '.id IN (' . $devUser . ')')
                ->andWhere(['is_active' => 1])
                ->andWhere(['role'=> [User::ROLE_CLIENT]]);

            $query2 = User::find()
                ->andWhere(['is_active' => 1])
                ->andWhere(['role'=> [User::ROLE_DEV, User::ROLE_ADMIN]]);

            $query = $query1->union($query2);
        }

        //CLIENT has an access to all active users who are DEV, ADMIN or SALES of their projects
        // and has an access to all columns except of salary, official_salary, salary_up, role, joined
        if(User::hasPermission([User::ROLE_CLIENT])) {
            $workers = ProjectCustomer::allClientWorkers(Yii::$app->user->id);
            $arrayWorkers = [];
            foreach($workers as $worker){
                $arrayWorkers[] = $worker->user_id;
            }
            $devUser = '';
            if(!empty($arrayWorkers)) {
                $devUser = implode(', ' , $arrayWorkers);
            }
            else{
                $devUser = 'null';
            }

            $query = User::find()
                ->where(User::tableName() . '.id IN (' . $devUser . ')')
                ->andWhere(['is_active' => 1])
                ->andWhere(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_ADMIN]]);

        }

       // DEV has an access to all active users who are DEV, ADMIN or SALES
        // to the following columns: id, first_name, last_name, company, email, phone
        if(User::hasPermission([User::ROLE_DEV])) {
            $query = User::find()->where(['is_active' => 1])
                ->andWhere(['role'=> [User::ROLE_DEV, User::ROLE_SALES, User::ROLE_ADMIN]]);
        }

        //column ID is shown only to ADMIN
        if(  User::hasPermission([User::ROLE_ADMIN])) {
            $columns [] = 'id';
        }

        $columns   []     = 'photo';
        $columns   []     = 'first_name';

        if( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])){
            $columns   []     = 'role';
        }
        $columns [] = 'email';
        $columns [] = 'phone';
        $columns [] = 'date_login';
        $columns [] = 'date_signup';
        if (User::hasPermission([User::ROLE_ADMIN])) {
            $columns [] = 'is_active';
        }
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $columns[] = 'salary';
            $columns[] = 'date_salary_up';
        }

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( $limit )
            ->setStart( $start )
            ->setSearchValue( $keyword )
            ->setSearchParams([ 'or',
                ['like', 'last_name', $keyword],
                ['like', 'first_name', $keyword],
                ['like', 'phone', $keyword],
                ['like', 'email', $keyword]
            ]);

        if( $order ){

            foreach ($order as $name => $value) {
                $dataTable->setOrder(User::tableName() . '.' . $name, $value);
            }

        } else {
            $dataTable->setOrder(User::tableName() . '.' . 'id', SortHelper::DESC);
        }

        $dataTable->setFilter('is_delete=0');

        if ($role && $role != null && isset(User::getRoles()[$role])){
            $dataTable->setFilter('role=\'' . $role . '\'');
        }

        if ($active === '1'){
            $dataTable->setFilter('is_active=1');
        } elseif ($active === '0') {
            $dataTable->setFilter('is_active=0');
        }
        $activeRecordsData = $dataTable->getData();
        $list = array();


        /* @var $model \app\models\User */
        foreach ( $activeRecordsData as $model ) {
            $row = array();
            if ($model->date_salary_up) {
                $salary_up =  DateUtil:: convertDateTimeWithoutHours($model->date_salary_up);
            } else {
                $salary_up = 'No Changes';
            }

            if ($model->photo) {
                $photo = urldecode(Url::to(['/cp/index/getphoto', 'entry' => Yii::getAlias('@app') .
                    '/data/' . $model->id . '/photo/' . $model->photo]));
            } else {
                $photo = "/img/avatar.png";
            }

            $row ['id'] = $model->id;
            $row ['image'] = $photo;
            $row ['first_name'] = $model->first_name;
            $row ['last_name'] = $model->last_name;
            $row ['company'] = $model->company;
            $row ['email'] = $model->email;
            $row ['phone'] = $model->phone;

            if (User::hasPermission([User::ROLE_FIN, User::ROLE_ADMIN])) {
                $row ['last_login'] = $model->date_login ? DateUtil::convertDatetimeWithoutSecund($model->date_login) : "The user didn't login";
                $row ['joined'] = DateUtil::convertDateTimeWithoutHours($model->date_signup);
                $row ['is_active'] = $model->is_active;
                $row ['salary'] = '$' . number_format($model->salary);
                $row ['official_salary'] = $model->official_salary;
                $row ['salary_up'] = $salary_up;
                $row ['role'] = $model->role;
                $row ['auth_type'] = $model->auth_type;
            }

            if (User::hasPermission([User::ROLE_SALES])) {
                $row ['role'] = $model->role;
                $row ['last_login'] = $model->date_login ? DateUtil::convertDatetimeWithoutSecund($model->date_login) : "The user didn't login";
                $row ['joined'] = DateUtil::convertDateTimeWithoutHours($model->date_signup);
                $row ['is_active'] = $model->is_active;
            }

            if (User::hasPermission([User::ROLE_CLIENT])) {
                $row ['last_login'] = $model->date_login ? DateUtil::convertDatetimeWithoutSecund($model->date_login) : "The user didn't login";
                $row ['is_active'] = $model->is_active;
            }

            $list[] = $row;
        }

        $data = [
            "users" => $list,
            "total_records" => DataTable::getInstance()->getTotal(),
        ];
        $this->setData($data);

    }
}