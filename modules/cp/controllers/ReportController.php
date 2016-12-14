<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 09.02.16
 * Time: 16:34
 */
namespace app\modules\cp\controllers;
use app\models\Invoice;
use app\models\Project;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\models\Team;
use app\models\Teammate;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\components\DataTable;
use app\components\DateUtil;

class ReportController extends DefaultController
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
                        'actions'   => ['index', 'find', 'edit', 'delete'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get', 'post'],
                    'find'  => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /** Value table (Reports) fields, filters, search */
    public function actionFind()
    {
        $order              = Yii::$app->request->getQueryParam("order");
        $search             = Yii::$app->request->getQueryParam("search");
        $projectId          = Yii::$app->request->getQueryParam("project_id");
        $usersId            = Yii::$app->request->getQueryParam("user_develop");
        $customerId         = Yii::$app->request->getQueryParam("user_id");
        $salesId            = Yii::$app->request->getQueryParam("user_id");
        $dateStart          = Yii::$app->request->getQueryParam("date_start");
        $dateEnd            = Yii::$app->request->getQueryParam("date_end");
        $keyword            = ( !empty($search['value']) ? $search['value'] : null);
        $query              = Report::find();

        $columns        = [
            'id',
            'task',
            'date_added',
            'name',
            'reporter_name',
            'date_report',
            'invoice_id',
            'hours'
        ];

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'reporter_name', $keyword],
                ['like', 'task', $keyword],
            ]);

        if( isset( $columns[$order[0]['column']]) ){

            $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        }else{

            $dataTable->setOrder( 'date_report', 'asc');
        }


        if($projectId && $projectId != null){

            $dataTable->setFilter('project_id=' . $projectId);
        }
        if($usersId && $usersId != null){

            $dataTable->setFilter('user_id=' . $usersId);
        }

        if($customerId && $customerId != null){

            $projectsCustomer = ProjectCustomer::getReportsOfCustomer($customerId);
            $projectId = [];
            foreach($projectsCustomer as $project){

                $projectId[] = $project->project_id;

            }
            if($projectId && $projectId != null) {

                $dataTable->setFilter('project_id IN (' . implode(', ', $projectId) . ") ");
            }else{

                $dataTable->setFilter('project_id IN (null) ');
            }

        }
        if(User::hasPermission([User::ROLE_CLIENT])) {

            $customer = Yii::$app->user->id;

            if($customer && $customer != null){

                $projectsCustomer = ProjectCustomer::getReportsOfCustomer($customer);
                $projectId = [];
                foreach($projectsCustomer as $project){

                    $projectId[] = $project->project_id;

                }
                if($projectId && $projectId != null) {

                    $dataTable->setFilter('project_id IN (' . implode(', ', $projectId) . ") ");
                }else{

                    $dataTable->setFilter('project_id IN (null) ');
                }

            }
        }
        if(User::hasPermission([User::ROLE_SALES])) {

            $salesid = Yii::$app->user->id;

            if($salesid && $salesid != null){

                $projectsDeveloper = ProjectDeveloper::getReportsOfSales($salesid );
                $projectId = [];
                foreach($projectsDeveloper as $project){

                    $projectId[] = $project->project_id;

                }
                if($projectId && $projectId != null) {

                    $dataTable->setFilter('project_id IN (' . implode(', ', $projectId) . ") ");
                }else{

                    $dataTable->setFilter('project_id IN (null) ');
                }

            }
        }
            if(User::hasPermission([User::ROLE_PM])) {
                $projects = Project::ProjectsCurrentUser(Yii::$app->user->id);
                $projectId = [];
                foreach ($projects as $project) {
                    $projectId[] = $project->id;
                }
                $dataTable->setFilter('project_id IN (' . implode(', ', $projectId) . ") ");

//                $teammates = [];
//                if ( ( $pmTeammates = Report::reportsPM() ) ) {
//
//                    foreach($pmTeammates as $teammate) {
//
//                        $teammates[] = $teammate->user_id;
//
//                    }
//                }
//                if( $teammates && count($teammates) ) {
//
//                    $dataTable->setFilter('user_id IN (' . implode(', ', $teammates) . ") ");
//                }else{
//
//                    $dataTable->setFilter('user_id IN (null) ');
//
//                }
            }

            if($dateStart && $dateStart != null){

               $dataTable->setFilter('date_report >= "' . DateUtil::convertData($dateStart). '" ');

            }

            if($dateEnd && $dateEnd != null){

                $dataTable->setFilter('date_report <= "' . DateUtil::convertData($dateEnd). '"');

            }

        $dataTable->setFilter('is_delete=0');

        $activeRecordsData = $dataTable->getData();
        $list = [];
        /* @var $model \app\models\Report */
        foreach ( $activeRecordsData as $model ) {

        $pD = ProjectDeveloper::findOne(['user_id' => $model->user_id,
                        'project_id' => $model->getProject()->one()->id ]);
        //    var_dump($pD);die();
                        
        $aliasUser = null;
        if ( $pD && $pD->alias_user_id ) {
        
            $aliasUser = User::findOne( $pD->alias_user_id );
        
        }
        //var_dump($aliasUser->first_name);die();

            $list[] = [
                $model->id,
                $model->task,
                $model->date_added,
                $model->getProject()->one()->name,
                /*(User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM]) &&
                ($aliasUser != null) ?
                    User::findOne($model->user_id)->first_name . " " .
                    User::findOne($model->user_id)->last_name .
                    '(' . $aliasUser->first_name . ' ' . $aliasUser->last_name . ')' :
                    User::findOne($model->user_id)->first_name . " " .
                    User::findOne($model->user_id)->last_name),*/

              ( User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_SALES]) &&
                ($aliasUser != null) ?
                    $aliasUser->first_name . ' ' .
                    $aliasUser->last_name .
                    '(' . User::findOne($model->user_id)->first_name . ' ' .
                          User::findOne($model->user_id)->last_name . ')' :
                        ( User::hasPermission([User::ROLE_CLIENT]) ?
                        $aliasUser->first_name . ' ' . $aliasUser->last_name :
                        User::findOne($model->user_id)->first_name . ' ' .
                        User::findOne($model->user_id)->last_name )),

                    $model->date_report,
                    ( $model->invoice_id == null ? "No" : "Yes" ),
                    $model->hours
            ];
        }

        $totalHours = $query->sum(Report::tableName() . '.hours');

        $data = [
            "draw"              => DataTable::getInstance()->getDraw(),
            "recordsTotal"      => DataTable::getInstance()->getTotal(),
            "recordsFiltered"   => DataTable::getInstance()->getTotal(),
            "totalHours"        => $totalHours,
            "data"              => $list
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content = json_encode($data);
        Yii::$app->end();
    }

}