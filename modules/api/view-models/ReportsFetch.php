<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 24.02.17
 * Time: 12:20
 */

namespace viewModel;

use app\components\DataTable;
use app\components\DateUtil;
use app\models\Project;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\models\User;
use Yii;
use app\modules\api\models\ApiAccessToken;

class ReportsFetch extends ViewModelAbstract
{
    public function define()
    {
        $usersId     = Yii::$app->request->getQueryParam('user_id');
        $date_period = Yii::$app->request->getQueryParam('date_period') ? Yii::$app->request->getQueryParam('date_period') : null;
        $projectId   = Yii::$app->request->getQueryParam('project_id') ? Yii::$app->request->getQueryParam('project_id') : null;
        $dateStart   = Yii::$app->request->getQueryParam('from_date') ? Yii::$app->request->getQueryParam('from_date') : 1; // ?
        $dateEnd     = Yii::$app->request->getQueryParam('to_date') ?  Yii::$app->request->getQueryParam('to_date') : null;
        $search      = Yii::$app->request->getQueryParam('search_query') ? Yii::$app->request->getQueryParam('search_query') : null;
        $is_invoiced = Yii::$app->request->getQueryParam('is_invoiced') ? Yii::$app->request->getQueryParam('is_invoiced') : null;
        $start       = Yii::$app->request->getQueryParam('start') ? Yii::$app->request->getQueryParam('start') : 1;//?;
        $limit       = Yii::$app->request->getQueryParam('limit') ? Yii::$app->request->getQueryParam('limit') : 1;//?;
        $order       = Yii::$app->request->getQueryParam('order', []) ? Yii::$app->request->getQueryParam('order', []) : 1;//?;













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


        if(User::hasPermission([User::ROLE_CLIENT])) {

            $customer = Yii::$app->user->id;

            if($customer && $customer != null){

                $projectsCustomer = ProjectCustomer::getReportsOfCustomer($customer);
                $projectId = [];
                foreach($projectsCustomer as $project){

                    $projectId[] = $project->project_id;

                }
                if($projectId && $projectId != null) {

                    $dataTable->setFilter(Report::tableName() . '.project_id IN (' . implode(', ', $projectId) . ") ");
                }
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
                if($projectId && $projectId != null) {

                    $dataTable->setFilter(Report::tableName() . '.project_id IN (' . implode(', ', $projectId) . ") ");
                }

            }
        }
        if(User::hasPermission([User::ROLE_PM])) {
            $projects = Project::ProjectsCurrentUser(Yii::$app->user->id);
            $projectId = [];
            foreach ($projects as $project) {
                $projectId[] = $project->id;
            }
            $dataTable->setFilter(Report::tableName() . '.project_id IN (' . implode(', ', $projectId) . ") ");
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

            $aliasUser = null;
            if ( $pD && $pD->alias_user_id ) {

                $aliasUser = User::findOne( $pD->alias_user_id );

            }
            $task = $model->task;

            $customer = ProjectCustomer::getProjectCustomer($model->getProject()->one()->id)->one();

            if( $customer ) {
                $customer_project =  $customer->user->first_name . ' ' . $customer->user->last_name . '<br>' . $model->getProject()->one()->name;
            } else {
                $customer_project = 'Customer NOT SET' . '<br>' . $model->getProject()->one()->name;
            }

            $user = (($aliasUser != null) ?
                $aliasUser->first_name . ' ' .
                $aliasUser->last_name .
                '(' . User::findOne($model->user_id)->first_name . ' ' .
                User::findOne($model->user_id)->last_name . ')' :
                (User::hasPermission([User::ROLE_CLIENT]) && $aliasUser ?
                    $aliasUser->first_name . ' ' . $aliasUser->last_name :
                    User::findOne($model->user_id)->first_name . ' ' .
                    User::findOne($model->user_id)->last_name));

            $date_report =  date("d/m/Y", strtotime($model->date_report));
            $hours = gmdate('H:i', floor($model->hours * 3600));
                $invoiceId = null;
                if ($model->invoice_id && ($model->invoice->is_delete == 0)) {
                    $invoiceId = $model->invoice_id;
                }
                $list[] = [
                    'report_id'     => $model->id,
                    'task'          => $task,
                    'created_date'  => date("d/m/Y", strtotime($model->date_added)),
                    'project'       => $customer_project,
                    $user,
                    $date_report,
                    ($invoiceId == null ? "No" : "Yes"),
                    $hours,
                    User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES]) ? '$' . number_format($model->cost, 2) : null,
                    $model->getProject()->one()->id,
                    $invoiceId
                ];


        }
        $activeRecordInstance->limit(null)->offset(null);
        $totalHours = Yii::$app->Helper->timeLength( $activeRecordInstance->sum('hours') * 3600);
        $totalCost = '$' . $activeRecordInstance->sum('cost');

        $data = [
            "reports"              => $list,
            "recordsTotal"      => DataTable::getInstance()->getTotal(),
            "totalHours"        => $totalHours,
            "totalCost"         => $totalCost,
        ];
        $this->setData($data);

    }
}