<?php
/**
 * Created by WebAIS.
 * User: Oleksii
 * Date: 09.06.2015
 * Time: 13:09
 */

namespace app\modules\cp\controllers;
use app\components\DateUtil;
use app\models\ProjectDeveloper;
use app\models\SiteUser;
use app\models\Visit;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\DataTable;
use app\components\AccessRule;
use app\models\Site;
use app\models\Story;
use app\models\Photo;
use app\models\User;
use app\models\Language;
use app\models\LoginForm;
use yii\web\Cookie;

class UserController extends DefaultController {

    public $enableCsrfValidation = false;
    public $layout = "admin";
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions'   => [ 'find', 'index', 'invite', 'delete', 'loginas', 'loginback', 'update', 'activate'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN],
                    ],
                    [
                        'actions'   => [ 'find', 'index', 'loginback'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES],
                    ],
                    [
                        'actions'   => ['loginback'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_DEV],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'find'      => ['get'],
                    'delete'    => ['delete'],
                    'invite'    => ['get', 'post'],
                    'loginas'   => ['get', 'post'],
                    'loginback' => ['get', 'post'],
                    'update'    => ['get', 'post'],
                    'activate'  => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    /** Delete user from Manage Users */
    public function actionDelete()
    {
        if (( $id = Yii::$app->request->post("id") ) ) {

            /** @var  $model User */
            $model  = User::findOne( $id );
            $model->date_signup = null;
            $model->date_login = null;
            $model->is_delete = 1;
            $model->save(true, ['is_delete', 'date_login', 'date_signup']);
            return json_encode([
                "message"   => Yii::t("app", "User # " . $id ." has been deleted "),
            ]);
        }
    }

    /** Activate/Suspend user from Manage Users */
    public function actionActivate()
    {
        if (( $id = Yii::$app->request->post("id") ) ) {
			
			$action = Yii::$app->request->post("action");
            /** @var  $model User */
            $model  = User::findOne($id);
			$model->is_active = $action == 'active' ? 0 : 1;
            $model->save(true, ['is_active']);
            return json_encode([
                "is_active"   => $model->is_active,
            ]);
        }
    }

    /** Value table (Manage Users) fields, filters, search */
    public function actionFind()
    {


        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);
		$role			= Yii::$app->request->getQueryParam("role");
		$active			= Yii::$app->request->getQueryParam("is_active");
		
        if( User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {

            $query = User::find();
        }

        if( User::hasPermission([User::ROLE_SALES, User::ROLE_PM])) {

            /* get all project id for asigned to sales */
            $all_project_ids = ProjectDeveloper::find()->where('user_id=:id AND is_sales=true',
                [
                    ':id' => Yii::$app->user->id
                ]
            )->all();

        /** array with all project id wich asigned to sales*/
        $projectId = [];
            foreach($all_project_ids as $project){

                $projectId[] = $project->project_id;

            }
        if(!empty($projectId)) {
            $devUser = implode(', ' , $projectId);
        }
        else{
            $devUser = 'null';
        }
		
        $query = User::find()
            ->leftJoin(ProjectDeveloper::tableName(),
                ProjectDeveloper::tableName() . '.user_id = ' . User::tableName() . '.id')
            ->where(ProjectDeveloper::tableName() . '.project_id IN (' . $devUser  . ')')
            ->groupBy('user_id');
        }
        if( User::hasPermission([User::ROLE_CLIENT])){

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

            $query = User::find()
                    ->where(User::tableName() . '.id IN (' . $devUser . ')') ;
        }
        $columns        = [
            'id',
            'first_name',
            'role',
            'email',
            'company',
            'phone',
            'date_login',
            'date_signup',
            'is_active',
            'salary',
            'date_salary_up',
        ];
        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'last_name', $keyword],
                ['like', 'first_name', $keyword],
                ['like', 'phone', $keyword],
                ['like', 'email', $keyword]
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        $dataTable->setFilter('is_delete=0');
			
		if ($role && $role != null && isset(User::getRoles()[$role])){
			$dataTable->setFilter('role=\'' . $role . '\'');
        }
		
		if ($active && $active == 'true'){
			$dataTable->setFilter('is_active=1');
        }

        $activeRecordsData = $dataTable->getData();
        $list = array();
        /* @var $model \app\models\User */
        foreach ( $activeRecordsData as $model ) {
            if ($model->date_salary_up){
                $salary_up = date('d/m/Y', strtotime($model->date_salary_up));
            } else {
                $salary_up = '';
            }
            $list[] = [
                $model->id,
                $model->first_name . " " . $model->last_name,
                $model->role,
                $model->email,
                $model->phone,
                DateUtil::convertDatetimeWithoutSecund($model->date_login),
                DateUtil::convertDatetimeWithoutSecund($model->date_signup),
                ( $model->is_active == 1 ? "Active" : "Suspended" ),
                User::hasPermission([User::ROLE_PM]) ? null : $model->salary,
                User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES ]) ? $salary_up:null,
                $model->is_delete,
                $model->public_profile_key
            ];
        }

        $data = [
            "draw"              => DataTable::getInstance()->getDraw(),
            "recordsTotal"      => DataTable::getInstance()->getTotal(),
            "recordsFiltered"   => DataTable::getInstance()->getTotal(),
            "data" => $list
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content = json_encode($data);
        Yii::$app->end();

    }

    /** Invited users add to database */
    public function actionInvite()
    {
            $model = new User();

            if ($model->load(Yii::$app->request->post())) {

                $userEmailes = User::findOne(['email' => $model->email]);

                $model->password = User::generatePassword();

                /** @var $userEmailes User */
                /** Invite user that was deleted again */
                if (!empty($userEmailes) && $userEmailes->is_delete == 1) {

                    $userEmailes->is_delete = 0;
                    $userEmailes->is_active = 0;
                    $userEmailes->invite_hash = md5(time());
                    $userEmailes->first_name = $model->first_name;
                    $userEmailes->last_name = $model->last_name;
                    $userEmailes->role = $model->role;
                    $userEmailes->company = $model->company;
                    $userEmailes->password = $model->password;
                    $userEmailes->rawPassword = $model->password;
                    $userEmailes->password = md5($model->password);
                    $userEmailes->date_signup = date('Y-m-d H:i:s');
                    $userEmailes->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You have restored and sent the invitation to deleted user"));
                    return $this->redirect('index');

                } else {
                    /** Invite new user*/
                    if ($model->validate()) {

                        $model->save();
                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "You have created and sent the invitation for the new user"));
                        return $this->redirect('index');

                    }
                }
            }

        return $this->render('invite',['model' => $model]);
    }

    public function actionLoginas()
    {
        /** @var $user User */
        if (( $id = Yii::$app->request->get("id") ) &&
            ( $user = User::findOne($id) ) ) {

            if ( $user->is_delete == 0 ) {

                if ( $user->is_active == 1 ) {

                    Yii::$app->response->cookies->add(new \yii\web\Cookie([
                        'name' => 'admin',
                        'value' => Yii::$app->user->id,
                    ]));

                    Yii::$app->user->logout();

                    /** @var  $model LoginForm */
                    $model = new LoginForm();
                    $model->loginUser($user);

                    if (User::hasPermission([User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])) {

                        return $this->redirect(['user/index']);

                    }
                    return $this->redirect(['index/index']);

                } else {

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, but you can not login as inactive user"));

                }

            } else {

                Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, but you can not login as deleted user"));
            }
        }
        return $this->redirect(['user/index']);

    }

    public function actionLoginback()
    {
        Yii::$app->user->logout();
        /** @var  $model LoginForm */
        $model = new LoginForm();

        if (isset(Yii::$app->request->cookies['admin']) &&
            ( $user = User::findOne( Yii::$app->request->cookies['admin'] ) ) ) {

            $form = new LoginForm();
            $form->loginUser( $user );
            Yii::$app->response->cookies->remove('admin');
            return $this->redirect('/backend/cp/index');

        }
        $this->redirect('user/index');
    }

    public function actionUpdate()
    {
        /** @var $user User */
        if (( $id = Yii::$app->request->get("id") ) &&
            ( $user = User::findOne($id) ) ) {
            $user->scenario = 'settings';
            if ($user->load(Yii::$app->request->post())) {
                if ($user->validate()) {
                    $user->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You edited user " . $id));
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->getSession()->setFlash('error',
                        Yii::t("app", "Data is not valid!!!"));
                }
            }
        }

        return $this->render('edit', [
            'model' => $user
        ]);
    }
}