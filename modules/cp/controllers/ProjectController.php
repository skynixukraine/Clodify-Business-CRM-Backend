<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 01.02.16
 * Time: 14:46
 */
namespace app\modules\cp\controllers;
use app\components\DateUtil;
use app\models\Project;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\models\Invoice;
use app\models\SiteUser;
use app\models\Visit;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\DataTable;
use app\components\AccessRule;
use app\models\Site;
use app\models\Story;
use app\models\Photo;
use app\models\User;
use app\models\Language;
class ProjectController extends DefaultController
{
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
                        'actions'   => [ 'index', 'find'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES],
                    ],
                    [
                        'actions'   => [ 'create', 'edit', 'delete', 'activate', 'suspend', 'update'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN],
                    ],
                    [
                        'actions'   => [ 'edit', 'activate', 'suspend', 'update'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_CLIENT],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get', 'post'],
                    'create'    => ['get', 'post'],
                    'find'      => ['get'],
                    'delete'    => ['delete'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /** Value table (Manage Projects) fields, filters, search */
    public function actionFind()
    {

        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);

        if (User::hasPermission([User::ROLE_ADMIN])) {
            $query         = Project::find()
                ->leftJoin(  ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id=" . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
                ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                ->groupBy('id');
        }

        if(User::hasPermission([User::ROLE_PM, User::ROLE_DEV] )){
        $query         = Project::find()
                            ->leftJoin(  ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id=" . Project::tableName() . ".id")
                            ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
                            ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                            ->groupBy('id');
        }
        if (User::hasPermission([User::ROLE_SALES])) {
            $query         = Project::find()
                ->leftJoin(  ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id=" . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
                ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                ->andWhere([ProjectDeveloper::tableName() . '.is_sales' => 1])
                ->groupBy('id');
        }
        if(User::hasPermission([User::ROLE_FIN, User::ROLE_CLIENT])){
        $query         = Project::find()
                            ->leftJoin(  ProjectCustomer::tableName(), ProjectCustomer::tableName() . ".project_id=" . Project::tableName() . ".id")
                            ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectCustomer::tableName() . ".user_id")
                            ->groupBy('id');
        }

        $columns        = [
            'id',
            'name',
            'jira_code',
            'total_logged_hours',
            'cost'];
        if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])){

            $columns[] = 'total_paid_hours';
        }
        array_push($columns, 'date_start',
                             'date_end',
                             'first_name',
                             'first_name',
                             'status');

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'name', $keyword],
                ['like', 'jira_code', $keyword]
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        if ( User::hasPermission([User::ROLE_CLIENT])) {

            $dataTable->setFilter( ProjectCustomer::tableName() . ".user_id=" . Yii::$app->user->id );
        }

        if( User::hasPermission([User::ROLE_PM, User::ROLE_SALES]) ){

            $dataTable->setFilter( ProjectDeveloper::tableName() . ".user_id=" . Yii::$app->user->id );

        }

           $dataTable->setFilter(Project::tableName() . '.is_delete=0');

        $activeRecordsData = $dataTable->getData();
        $list = [];
        /* @var $model \app\models\Project */
        foreach ( $activeRecordsData as $model ) {

            $developers = $model->getDevelopers()->all();
            $developersNames = [];
            $develop = [];
            /*  @var $developer \app\models\User */
            foreach($developers as $developer){

                /** @var  $alias_user ProjectDeveloper*/
                if($alias_user = ProjectDeveloper::findOne(['user_id' => $developer->id,
                                                            'project_id' => $model->id])->alias_user_id) {
                    $aliases = User::find()
                                ->where('id=:alias', [
                                        ':alias' => $alias_user])->one()->first_name . ' ' .
                               User::find()
                                ->where('id=:alias', [
                                    ':alias' => $alias_user])->one()->last_name;
                    if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_FIN, User::ROLE_SALES] )){
                        $developer->id == $alias_user ? $developersNames[] = $aliases:
                        $developersNames[] = $aliases . '(' . $developer->first_name ." ". $developer->last_name . ')';
                    }
                    elseif (User::hasPermission([User::ROLE_CLIENT] )){
                        $developer->id == $alias_user ?
                        $developersNames[] = $developer->first_name . ' ' . $developer->last_name:
                        $developersNames[] = $aliases;
                    }
                    } else {
                        $developersNames[] = $developer->first_name . ' ' . $developer->last_name;
                    }
                //$aliases[$developer->user_id] = $developer->alias_user_id;

            }
            $customers = $model->getCustomers()->all();
            $customersNames = [];
            /*  @var $customer \app\models\User */
            foreach($customers as $customer){

                $customersNames[] = $customer->first_name . " " .  $customer->last_name;
            }
            /* @var $model \app\models\Project */
            $cost = null;
            $row = [];
            //formatting date
            $newDateStart =$model->date_start ? date("d/m/Y", strtotime($model->date_start)): "Date Start Not Set";
            $newDateEnd = $model->date_end ? date("d/m/Y", strtotime($model->date_end)) : "Date End Not Set";

            $row = [
                $model->id,
                $model->name,
                $model->jira_code,
                gmdate('H:i', floor($model->total_logged_hours * 3600)),
            ];
            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES])) {
                $row[] = '$' . number_format( $model->cost, 2, ',	', '.');
            }
            if(User::hasPermission([User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES])) {
                $row[] = gmdate('H:i', floor($model->total_paid_hours * 3600));
            }
            $row[] = $newDateStart;
            $row[] = $newDateEnd ;
            $row[] = implode(", ", $developersNames);
            $row[] = $customersNames ? implode(", ", $customersNames): "Customer Not Set";
            $row[] = $model->status;

            $list[] = $row;
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

    /** Delete project */
    public function actionDelete()
    {
        if ( ( $id = Yii::$app->request->post("id") ) ) {

            /** @var  $model Project */
            $model  = Project::findOne( $id );
            $model->is_delete = 1;
            $model->save(true, ['is_delete']);
            return json_encode([
                "message"   => Yii::t("app", "You deleted project " . $id),
                "success"   => true
            ]);
        }
    }

    /** Add new project */
    public function actionCreate()
    {
            $model = new Project();

            $model->scenario = "admin";
            if ($model->load(Yii::$app->request->post())) {
                $model->status = Project::STATUS_NEW;
                if ($model->validate() && $model->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You created project " . $model->id));
                    return $this->redirect(['index']);
                } 
            }
            return $this->render('create', ['model' => $model,
                                            'title' => 'Create a new project']);
    }

    /** Edit project */
    public function actionEdit()
    {
           if( $id = Yii::$app->request->get('id') ) {

               $model  = Project::findOne($id);
               $aliases = [];
               /** @var $model Project */
               if( $model->is_delete == 0) {

                   $model->date_start = DateUtil::reConvertData($model->date_start);
                   $model->date_end = DateUtil::reConvertData($model->date_end);

                   if ($model->load(Yii::$app->request->post())) {

                           if ($model->validate()) {

                               if( $model->date_start == null ||
                                   $model->date_end == null ||
                                   DateUtil::compareDates($model->date_start, $model->date_end) ||
                                   ($model->date_start == null && $model->date_end == null) ) {

                                   $model->save();

                                   if(Yii::$app->request->post('updated')) {

                                       Yii::$app->getSession()->setFlash('success',
                                       Yii::t("app", "You edited project " . $id));
                                   }
                                   return $this->redirect(['index']);

                               }else{

                                   Yii::$app->getSession()->setFlash('error',
                                   Yii::t("app", "Start date must be less than end date"));
                               }
                           }
                       }else {

                           $customers = $model->getProjectCustomers()
                               ->all();
                           $model->customers = [];
                           foreach ($customers as $customer) {

                               /** @var $customer ProjectCustomer */
                               $model->customers[] = $customer->user_id;
                           }

                           $developers = $model->getProjectDevelopers()
                               ->all();
                           $model->developers = [];
                           foreach ($developers as $developer) {
                               $aliases[$developer->user_id] = $developer->alias_user_id;
                               $model->developers[] = $developer->user_id;
                           }
                       }
               }else{

                   Yii::$app->getSession()->setFlash('error', Yii::t("app", "Oops, sorry, this project is deleted and can not be accessible anymore"));
                   return $this->redirect(['index']);
               }

           }
           return $this->render('create',
               [
                   'model' => $model,
                   'aliases' => $aliases,
                   'title' => 'Edit the project #' . $model->id
               ]
           );

    }
    /** Project's status change on IN PROGRESS  */
    public function actionActivate()
    {
        if( $id = Yii::$app->request->get('id') ) {

            $model  = Project::findOne($id);
            if( $model->status != Project::STATUS_INPROGRESS ) {

                $model->status = Project::STATUS_INPROGRESS;
                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You activated project " . $id));

            }else{

                Yii::$app->getSession()->setFlash('error', Yii::t("app", "This project is already active"));

            }

        }
        return $this->render('index', ['model' => $model]);
    }

    /** Project's status change on ONHOLD  */
    public function actionSuspend()
    {
        if ($id = Yii::$app->request->get('id')) {

            $model = Project::findOne($id);

            if ($model->status != Project::STATUS_ONHOLD) {

                $model->status = Project::STATUS_ONHOLD;
                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You suspended project " . $id));

            } else {

                Yii::$app->getSession()->setFlash('error', Yii::t("app", "This project is already suspend"));

            }
            return $this->render('index', ['model' => $model]);
        }
    }
}