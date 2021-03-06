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
use Mpdf\Mpdf;

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
                        'actions'   => ['index', 'find', 'edit', 'delete', 'download'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES, User::ROLE_CLIENT],
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
        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $projects = Project::getProjectsDropdownForAdminAndFin(Yii::$app->user->id);
        } else if (User::hasPermission([User::ROLE_SALES])) {
            $projects = Project::getProjectsDropdownForSales(Yii::$app->user->id);
        } else if (User::hasPermission([User::ROLE_CLIENT])) {
            $projects = Project::getProjectsDropdownForClient(Yii::$app->user->id);
        }
        return $this->render('index', compact('projects'));
    }

    public function actionDownload() {

        $params = Yii::$app->request->get();
        $data = $this->prepareData($params, 'pdf');

        $filters = [];
        if(!is_dir('../data/reports')){
            mkdir('../data/reports');
        }

        $fileName = 'reports';
        if($date_start = $params["date_start"] ) {
            $fileName  .= '_' . str_replace('/', '_', $date_start );
            $filters ['date_start'] = $date_start;

        }
        if (isset($params["date_end"]) && ($date_end = $params["date_end"]) ) {
            $fileName   .= '_'. str_replace('/', '_',  $date_end );
            $filters ['date_end'] = $date_end;
        }
        if(isset($params["user_develop"]) && ($user_id = $params["user_develop"]) ) {
            $fileName .= '_' . $user_id;
            $user = User::findOne($user_id);
            $filters ['user_name'] = $user->first_name . ' ' . $user->last_name;
        }
        if(isset($params["project_id"]) && ($project_id = $params["project_id"])) {
            $fileName .= '_' . $params["project_id"];
            $project = Project::findOne($project_id);
            $filters ['project_name'] = $project->name;
        }

        if($search =  $params["search"]["value"] ) {
            $fileName .= '_filtered';
            $filters['keyword'] = $search;
        }

        $fileName .=  '.pdf';

        $html = $this->renderPartial('reportsPDF', [
            'reportData' => $data['data'],
            'totalHours' => $data['totalHours'],
            'filters'    => $filters

        ]);

        $pdf = new Mpdf();
        @$pdf->WriteHTML($html);
        $pdf->Output($fileName,  'D');

        header("Content-type:application/pdf"); //for pdf file
        header('Content-Disposition: attachment; filename="' . basename('../data/reports/'. $fileName ) . '"');
        header('Content-Length: ' . filesize('../data/reports/'.$fileName ));
        readfile('../data/reports/'.$fileName );
        Yii::$app->end();
    }

    //Prepare data for PDF and table formats
    public function prepareData( $data, $output = 'table' )
    {
        $order = null;
        $search = null;
        if (isset($data['order']) && isset($data['search'])) {
        $order = $data["order"];
        $search = $data["search"];
        }
        $projectId = $usersId = $salesId = $dateStart = $dateEnd = $customerId = null;

        if(isset($data["project_id"])) {
            $projectId  = $data["project_id"];
        }
        if(isset($data["user_develop"])) {
            $usersId    = $data["user_develop"];
        }
        if(isset($data["user_id"])) {
            $customerId = $data["user_id"];
            $salesId    = $data["user_id"];
        }
        if(isset($data["date_start"]) ) {
            $dateStart  = $data["date_start"];
        }
        if(isset($data["date_end"]) ) {
            $dateEnd    = $data["date_end"];
        }

        $keyword            = ( !empty($search['value']) ? $search['value'] : null);

        $query              = Report::find()
            ->leftJoin(User::tableName(), User::tableName() . '.id=' . Report::tableName() . '.user_id')
            ->leftJoin(Project::tableName(), Project::tableName() . '.id=' . Report::tableName() . '.project_id')
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=' . Project::tableName() . '.id' )
            ->where(Project::tableName() . '.status IN ("' . Project::STATUS_ONHOLD . '", "' . Project::STATUS_INPROGRESS . '")')
            ->andWhere(Project::tableName() . '.is_delete=0')
            ->groupBy(Report::tableName() . '.id');

        $columns        = [
            'id',
            'task',
            'date_added',
            'name',
            'reporter_name',
            'invoice_id',
            'hours',
            'date_report',
        ];

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ); //$search['value']

        if ($output == 'table') {
            $dataTable->setLimit( Yii::$app->request->getQueryParam("length") );
        }

        $dataTable->setSearchParams([ 'or',
            ['like', 'reporter_name', $keyword],
            ['like', 'task', $keyword],
        ]);

        if( isset( $columns[$order[0]['column']]) ){
            $dataTable->setOrder(Report::tableName() . '.' . $columns[$order[0]['column']], $order[0]['dir']);

        }else{

            $dataTable->setOrder( Report::tableName() . '.date_report', 'asc');
        }


        if($projectId && $projectId != null){

            $dataTable->setFilter(Report::tableName() . '.project_id=' . $projectId);
        }
        if($usersId && $usersId != null){

            $dataTable->setFilter(Report::tableName() . '.user_id=' . $usersId);
        }

        if (User::hasPermission([User::ROLE_ADMIN])) {

            if ($customerId && $customerId != null) {

                $projectsCustomer = ProjectCustomer::getReportsOfCustomer($customerId);
                $projectId = [];
                foreach ($projectsCustomer as $project) {

                    $projectId[] = $project->project_id;

                }

                $projects = $projectId ? implode(', ', $projectId) : 0;
                $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projects . ') ');

            }
        }

        if (User::hasPermission([User::ROLE_CLIENT])) {

            $customer = Yii::$app->user->id;

            if($customer && $customer != null){

                $projectsCustomer = ProjectCustomer::getReportsOfCustomer($customer);
                $projectId = [];
                foreach($projectsCustomer as $project){

                    $projectId[] = $project->project_id;

                }

                $projects = $projectId ? implode(', ', $projectId) : 0;
                $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projects . ') ');
                $dataTable->setFilter(User::tableName() . '.role!="' . User::ROLE_FIN . '"');

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

                $projects = $projectId ? implode(', ', $projectId) : 0;
                $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projects . ') ');

            }
        }

        if(User::hasPermission([User::ROLE_PM])) {
            $projects = Project::ProjectsCurrentUser(Yii::$app->user->id);
            $projectId = [];
            foreach ($projects as $project) {
                $projectId[] = $project->id;
            }

            $projects = $projectId ? implode(', ', $projectId) : 0;
            $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projects . ') ');

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

            $dataTable->setFilter(Report::tableName() . '.date_report >= "' . DateUtil::convertData($dateStart). '" ');

        }

        if($dateEnd && $dateEnd != null){

            $dataTable->setFilter(Report::tableName() . '.date_report <= "' . DateUtil::convertData($dateEnd). '"');

        }

        $dataTable->setFilter(Report::tableName() . '.is_delete=0');
        $activeRecordInstance   = $dataTable->getQuery();
        $activeRecordsData      = $dataTable->getData();
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
            //if (strlen($model->task) >= 35) {
              //  $task = substr($model->task, 0, 35) . '...';
           // } else {
                $task = $model->task;
           // }

            $customer = ProjectCustomer::getProjectCustomer($model->getProject()->one()->id)->one();

            if( $customer ) {
                $customer_project =  $customer->user->first_name . ' ' . $customer->user->last_name . '<br>' . $model->getProject()->one()->name;
            } else {
                $customer_project = 'Customer NOT SET' . '<br>' . $model->getProject()->one()->name;
            }

            $userDeveloper = User::findOne($model->user_id);

            $user = (($aliasUser != null) ?
                $aliasUser->first_name . ' ' .
                $aliasUser->last_name :
                (User::hasPermission([User::ROLE_CLIENT]) && $aliasUser ?
                    $aliasUser->first_name . ' ' . $aliasUser->last_name :
                    $userDeveloper->first_name . ' ' . $userDeveloper->last_name));

            /**
             * Output an alias developer and developer on dashboard report
             * if download reports output only an alias developer
             */
            if (!User::hasPermission([User::ROLE_CLIENT]) && $aliasUser && $output != 'pdf') {
                $user .= '(' . $userDeveloper->first_name . ' ' . $userDeveloper->last_name . ')';
            }


            $date_report =  date("d/m/Y", strtotime($model->date_report));
            $hours = gmdate('H:i', floor($model->hours * 3600));
            if ($output == 'table') {
                $invoiceId = null;
                if ($model->invoice_id && ($model->invoice->is_delete == 0)) {
                    $invoiceId = $model->invoice_id;
                }
                $list[] = [
                    $model->id,
                    $task,
                    date("d/m/Y", strtotime($model->date_added)),
                    $customer_project,
                    /*(User::hasPermission([User::ROLE_ADMIN, User::ROLE_PM]) &&
                    ($aliasUser != null) ?
                        User::findOne($model->user_id)->first_name . " " .
                        User::findOne($model->user_id)->last_name .
                        '(' . $aliasUser->first_name . ' ' . $aliasUser->last_name . ')' :
                        User::findOne($model->user_id)->first_name . " " .
                        User::findOne($model->user_id)->last_name),*/
                    $user,
                    $date_report,
                    ($invoiceId == null ? "No" : "Yes"),
                    $hours,
                    User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES]) ? '$' . number_format($model->cost, 2) : null,
                    $model->getProject()->one()->id,
                    $invoiceId
                ];

            } else {

                $list[] = [
                    'task'      => $task,
                    'developer' => $user,
                    'date'      => $date_report,
                    'project'   => $customer_project,
                    'hours'     => $hours
                ];
            }

        }
        $activeRecordInstance->limit(null)->offset(null);
        $totalHours = Yii::$app->Helper->timeLength( $activeRecordInstance->sum('hours') * 3600);
        $totalCost = '$' . $activeRecordInstance->sum('cost');

        $data = [
            "draw"              => DataTable::getInstance()->getDraw("reports"),
            "recordsTotal"      => DataTable::getInstance()->getTotal(),
            "recordsFiltered"   => DataTable::getInstance()->getTotal(),
            "totalHours"        => $totalHours,
            "totalCost"         => $totalCost,
            "data"              => $list
        ];
        return $data;
    }


    /** Value table (Reports) fields, filters, search */
    public function actionFind()
    {
        $data = $this->prepareData(Yii::$app->request->get());

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content = json_encode($data);
        Yii::$app->end();
    }

}