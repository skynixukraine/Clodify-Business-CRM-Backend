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
use app\modules\api\components\Api\Processor;
use Yii;
use DateTime;
use app\modules\api\components\SortHelper;

/**
 * Fetch reports data. Available date, project, user, keyword and invoice filters.
 * All GET params are optional.
 * Class ReportsFetch
 * @package viewModel
 */
class ReportsFetch extends ViewModelAbstract
{
    public function define()
    {
        $usersId     = Yii::$app->request->getQueryParam('user_id');
        $date_period = Yii::$app->request->getQueryParam('date_period');
        $projectId   = Yii::$app->request->getQueryParam('project_id');
        $dateStart   = Yii::$app->request->getQueryParam('from_date');
        $dateEnd     = Yii::$app->request->getQueryParam('to_date');
        $keyword     = Yii::$app->request->getQueryParam('search_query');
        $is_invoiced = Yii::$app->request->getQueryParam('is_invoiced');
        $start       = Yii::$app->request->getQueryParam('start') ? Yii::$app->request->getQueryParam('start') : 0;
        $limit       = Yii::$app->request->getQueryParam('limit') ? Yii::$app->request->getQueryParam('limit') : SortHelper::DEFAULT_LIMIT;
        $order       = Yii::$app->request->getQueryParam('order', []);

        if ($date_period && ($dateStart || $dateEnd)) {
            return $this->addError(Processor::ERROR_PARAM, 'date_period can not be used with from_date/to_date');
        }

        $query = Report::find()
            ->leftJoin(User::tableName(), User::tableName() . '.id=' . Report::tableName() . '.user_id')
            ->leftJoin(Project::tableName(), Project::tableName() . '.id=' . Report::tableName() . '.project_id')
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=' . Project::tableName() . '.id ' .
                ' AND ' . Report::tableName() . '.user_id=' . ProjectDeveloper::tableName() . '.user_id' )
            ->andWhere(Project::tableName() . '.is_delete=0')
            ->groupBy(Report::tableName() . '.id');


        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( $limit )
            ->setStart( $start )
            ->setSearchValue( $keyword )
            ->setSearchParams([ 'or',
                ['like', 'reporter_name', $keyword],
                ['like', 'task', $keyword],
            ]);
        if( $order ){
            foreach ($order as $name => $value) {
                $dataTable->setOrder(Report::tableName() . '.' . $name, $value);
            }

        }else{

            $dataTable->setOrder( Report::tableName() . '.date_report', 'asc');
        }

        if($projectId && $projectId != null){

            $dataTable->setFilter(Report::tableName() . '.project_id=' . $projectId);
        }
        if($usersId && $usersId != null){

            if (User::hasPermission([User::ROLE_CLIENT]) ) {

                $dataTable->setFilter(Report::tableName() . '.user_id=' . $usersId . ' OR ' .
                    ProjectDeveloper::tableName() . '.alias_user_id=' . $usersId);

            } else {

                $dataTable->setFilter(Report::tableName() . '.user_id=' . $usersId);

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

                $projects = $projectId ? implode(', ', $projectId) : 0;

                $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projects . ') ');
                $dataTable->setFilter(Report::tableName() . '.is_approved=1 ');
            }
        }

        if(User::hasPermission([User::ROLE_SALES])) {

            $salesid = Yii::$app->user->id;

            if($salesid && $salesid != null && $salesid != $usersId){

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
            $pmid = Yii::$app->user->id;

            if($pmid && $pmid != null && $pmid != $usersId){

                $projects = Project::ProjectsCurrentUser(Yii::$app->user->id);
                $projectId = [];
                foreach ($projects as $project) {
                    $projectId[] = $project->id;
                }
                $projects = $projectId ? implode(', ', $projectId) : 0;
                $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projects . ') ');

            }

        }

        if (User::hasPermission([User::ROLE_DEV])) {
            $dataTable->setFilter(Report::tableName() . '.user_id=' . Yii::$app->user->id);
        }


        $date = new DateTime();
        switch ($date_period) {
            case 1:
                $dateStart = date('Y-m-d');
                break;
            case 2:
                $dateStart = $date->modify("last Monday")->format('Y-m-d');
                $dateEnd = $date->modify("next Sunday")->format('Y-m-d');
                break;
            case 3:
                $dateStart = $date->modify("first day of this month")->format('Y-m-d');
                $dateEnd = $date->modify("last day of this month")->format('Y-m-d');
                break;
            case 4:
                $dateStart = $date->modify("first day of this month")->format('Y-m-d');
                $dateEnd = $date->modify("last day of previous month")->format('Y-m-d');
                break;
        }

        if($dateStart) {
            $dataTable->setFilter(Report::tableName() . '.date_report >= "' . DateUtil::convertData($dateStart) . '" ');
        }

        if($dateEnd){
            $dataTable->setFilter(Report::tableName() . '.date_report <= "' . DateUtil::convertData($dateEnd) . '"');
        }

        $dataTable->setFilter(Report::tableName() . '.is_delete=0');

        if ($is_invoiced === '1') {
            $dataTable->setFilter(Report::tableName() . '.invoice_id IS NOT NULL');
        } elseif ($is_invoiced === '0') {
            $dataTable->setFilter(Report::tableName() . '.invoice_id IS NULL');
        }


        $activeRecordInstance   = $dataTable->getQuery();
        $activeRecordsData      = $dataTable->getData();

        $list = [];
        /* @var $model \app\models\Report */
        foreach ( $activeRecordsData as $key=>$model ) {
            $pD = ProjectDeveloper::findOne(['user_id' => $model->user_id,
                'project_id' => $model->getProject()->one()->id ]);

            $aliasUser = null;
            if ( $pD && $pD->alias_user_id ) {

                $aliasUser = User::findOne( $pD->alias_user_id );

            }


            $user = (($aliasUser != null) ?
                $model->reporter_name .
                ( !User::hasPermission([User::ROLE_CLIENT]) ?
                    '(' . User::findOne($model->user_id)->first_name . ' ' .
                    User::findOne($model->user_id)->last_name . ')'
                    : "" )
                :
                    User::findOne($model->user_id)->first_name . ' ' .
                    User::findOne($model->user_id)->last_name);

            $date_report =  date("d/m/Y", strtotime($model->date_report));
            $hours = gmdate('H:i', floor($model->hours * 3600));

            $list[$key] = [
                'report_id'     => $model->id,
                'project'       => [
                    'id'   => $model->getProject()->one()->id,
                    'name' => $model->getProject()->one()->name
                ],
                'created_date'  => date("d/m/Y", strtotime($model->date_added)),
                'task'          => $model->task,
                'hour'          => $hours,
                'cost'          => $model->cost,
                'is_approved'   => $model->is_approved ? true : false,
                'reporter'      => [
                    'id'   => $model->user_id,
                    'name' => $user
                ],
                'reported_date' => $date_report,
                'is_invoiced'   => $model->invoice_id ? 1 : 0
            ];

            if(User::hasPermission([User::ROLE_CLIENT])) {
                unset($list[$key]['cost']);
            }
        }

        $activeRecordInstance->limit(null)->offset(null);
        $totalHours = Yii::$app->Helper->timeLength( $activeRecordInstance->sum('hours') * 3600);
        $totalCost = $activeRecordInstance->sum('cost');

        if(!$totalCost)
            $totalCost = 0;

        $approvedHours = Yii::$app->Helper->timeLength( $activeRecordInstance->where('is_approved=1')->sum('hours') * 3600 );
        $approvedCost = $activeRecordInstance->sum('cost');

        if(!$approvedCost)
            $approvedCost = 0;

        $data = [
            "reports"            => $list,
            "total_records"      => DataTable::getInstance()->getTotal(),
            "total_hours"        => $totalHours,
            "total_cost"         => (float)$totalCost,
            "approved_hours"     => $approvedHours,
            "approved_cost"      => (float)$approvedCost,

        ];

        if(User::hasPermission([User::ROLE_CLIENT])) {
            unset($data['total_cost']);
        }

        $this->setData($data);

    }
}