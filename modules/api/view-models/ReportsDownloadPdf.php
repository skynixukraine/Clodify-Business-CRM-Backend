<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 7/5/18
 * Time: 5:25 PM
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
use Mpdf\Mpdf;
use Yii;
use DateTime;
use app\modules\api\components\SortHelper;

/**
 * Class ReportsDownloadPdf
 * @package viewModel
 */
class ReportsDownloadPdf extends ViewModelAbstract
{
    public function define()
    {

        if (!User::hasPermission([User::ROLE_ADMIN, User::ROLE_SALES, User::ROLE_FIN, User::ROLE_PM, User::ROLE_CLIENT])) {


            $this->addError(Processor::CODE_ACTION_RESTRICTED, Yii::t('app', 'Download PDF Reports function is not accessible'));
            return false;

        }
        $usersId     = Yii::$app->request->getQueryParam('user_id');
        $date_period = Yii::$app->request->getQueryParam('date_period');
        $projectId   = Yii::$app->request->getQueryParam('project_id');
        $dateStart   = Yii::$app->request->getQueryParam('from_date');
        $dateEnd     = Yii::$app->request->getQueryParam('to_date');
        $keyword     = Yii::$app->request->getQueryParam('search_query');

        if ($date_period && ($dateStart || $dateEnd)) {
            return $this->addError(Processor::ERROR_PARAM, 'date_period can not be used with from_date/to_date');
        }

        $query = Report::find()
            ->leftJoin(User::tableName(), User::tableName() . '.id=' . Report::tableName() . '.user_id')
            ->leftJoin(Project::tableName(), Project::tableName() . '.id=' . Report::tableName() . '.project_id')
            ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . '.project_id=' . Project::tableName() . '.id' )
            ->andWhere(Project::tableName() . '.is_delete=0')
            ->groupBy(Report::tableName() . '.id');


        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( 1000 )
            ->setStart( 0 )
            ->setSearchValue( $keyword )
            ->setSearchParams([ 'or',
                ['like', 'reporter_name', $keyword],
                ['like', 'task', $keyword],
            ]);
        $dataTable->setOrder(Report::tableName() . '.date_report', 'ASC');

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

                $projectId = $projectId ? implode(', ', $projectId) : 0;

                $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projectId . ') ');
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

                $projectId = $projectId ? implode(', ', $projectId) : 0;

                $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projectId . ') ');

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
                $projectId = $projectId ? implode(', ', $projectId) : 0;
                $dataTable->setFilter(Report::tableName() . '.project_id IN (' . $projectId . ') ');

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



        $activeRecordInstance   = $dataTable->getQuery();
        $activeRecordsData      = $dataTable->getData();

        $list       = [];
        $totalHours = 0;
        /* @var $model \app\models\Report */
        foreach ( $activeRecordsData as $key=>$model ) {
            $pD = ProjectDeveloper::findOne(['user_id' => $model->user_id,
                'project_id' => $model->getProject()->one()->id ]);

            $aliasUser = null;
            if ( $pD && $pD->alias_user_id ) {

                $aliasUser = User::findOne( $pD->alias_user_id );

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
            $totalHours += $model->hours;
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

        $filters = [];

        $fileName = 'reports';
        if( $dateStart ) {
            $fileName  .= '_' . $dateStart;
            $filters ['date_start'] = $dateStart;

        }
        if ( $dateEnd ) {
            $fileName   .= '_'. $dateEnd;
            $filters ['date_end'] = $dateEnd;
        }
        if( $usersId > 0 ) {
            $fileName .= '_' . $usersId;
            $user = User::findOne($usersId);
            $filters['user_name'] = $user->first_name . ' ' . $user->last_name;
        }
        if( $projectId > 0 ) {
            $fileName .= '_' . $projectId;
            $project = Project::findOne($projectId);
            $filters ['project_name'] = $project->name;
        }

        if( $keyword ) {
            $fileName .= '_filtered';
            $filters['keyword'] = $keyword;
        }

        $fileName .=  '.pdf';

        $html = Yii::$app->controller->renderPartial('reportsPDF', [
            'filters'       => $filters,
            'reportData'    => $list,
            'totalHours'    => gmdate('H:i', floor($totalHours * 3600))

        ]);

        $pdf = new Mpdf();
        @$pdf->WriteHTML($html);

        $this->setData(
            [
                'pdf' => base64_encode($pdf->Output($fileName, 'S')),
                'name' => $fileName
            ]
        );

    }
}