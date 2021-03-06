<?php
/**
 * Created by Skynix Team
 * Date: 13.04.17
 * Time: 9:14
 */

namespace viewModel;

use app\models\Milestone;
use phpDocumentor\Reflection\Types\Array_;
use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\components\DateUtil;
use app\models\Project;
use app\models\User;
use app\models\Report;
use app\models\ProjectDeveloper;
use app\models\ProjectCustomer;
use app\modules\api\components\Api\Processor;
use yii\helpers\ArrayHelper;

class ProjectFetch extends ViewModelAbstract
{
    public function define()
    {
        $order          = Yii::$app->request->getQueryParam('order', []);
        $filterById     = Yii::$app->request->getQueryParam('id');
        $keyword        = Yii::$app->request->getQueryParam('search_query');
        $start          = Yii::$app->request->getQueryParam('start', 0);
        $limit          = Yii::$app->request->getQueryParam('limit', SortHelper::DEFAULT_LIMIT);
        $subscribedOnly = Yii::$app->request->getQueryParam('subscribedOnly');
        $ongoingOnly    = Yii::$app->request->getQueryParam('ongoingOnly');
        $customerId     = Yii::$app->request->getQueryParam('customer_id');

        if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN])) {
            $query = Project::find()
                ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id="
                    . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
                ->groupBy('id');
        }
        if (User::hasPermission([User::ROLE_PM] )) {
            $query = Project::find()
                ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id="
                    . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
                ->andWhere([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                ->groupBy('id');
        }
        if (User::hasPermission([User::ROLE_SALES])) {
            $query = Project::find()
                ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id="
                    . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
                ->andWhere([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                ->groupBy('id');
        }

        if (User::hasPermission([User::ROLE_CLIENT])) {
            $query = Project::find()
                ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . ".project_id="
                    . Project::tableName() . ".id")
                ->where([ProjectCustomer::tableName() . '.user_id' => Yii::$app->user->id]);
        }

        if (User::hasPermission([User::ROLE_DEV])) {
            $query = Project::find()
                ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id="
                    . Project::tableName() . ".id")
                ->andWhere([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id]);
        }

        if ($customerId && isset($query) && !User::hasPermission([User::ROLE_CLIENT])) {
            $query->leftJoin(ProjectCustomer::tableName(),
                Project::tableName() . '.id=' . ProjectCustomer::tableName() . '.project_id')
                ->andWhere([ProjectCustomer::tableName() . '.user_id' => $customerId]);
        }

        if ( $filterById > 0 ) {

            $query->andWhere([Project::tableName() . '.id' => $filterById]);

        }
        $dataTable = DataTable::getInstance()
            ->setQuery($query)
            ->setLimit($limit)
            ->setStart($start)
            ->setSearchValue($keyword)
            ->setSearchParams([ 'or',
                ['like', 'name', $keyword],
                ['like', 'jira_code', $keyword]
            ]);

        if (!empty($keyword) && ($date = DateUtil::convertData($keyword)) !== $keyword) {
            $dataTable->setSearchParams([ 'or',
                ['like', 'date_start', $date],
                ['like', 'date_end', $date],
            ]);
        }
        if ($order) {
            foreach ($order as $name => $value) {
                $dataTable->setOrder(Project::tableName() . '.' . $name, $value);
            }

        } else {
            $dataTable->setOrder( Project::tableName() . '.id', 'asc');
        }

        $dataTable->setFilter(Project::tableName() . '.is_delete=0');

        //Implement filter subscribedOnly, if it is set to true output the projects where user ticked box as ACTIVE(subscribe)
        if ( !User::hasPermission([User::ROLE_CLIENT]) &&
            !empty($subscribedOnly) &&
            $subscribedOnly === ProjectDeveloper::IS_SUBSCRIBED) {
            $emplId = Yii::$app->user->id;

            if($emplId && $emplId != null){

                $projectsDeveloper = ProjectDeveloper::getProjectForEmployee($emplId );
                $projectId = [];
                foreach($projectsDeveloper as $project){
                    $projectId[] = $project->project_id;
                }
                $projects = $projectId ? implode(', ', $projectId) : 0;
                $dataTable->setFilter(Project::tableName() . '.id IN (' . $projects . ') ');
                $dataTable->setFilter(Project::tableName() . '.status="' . Project::STATUS_INPROGRESS . '"');
            }
        }

        if ($ongoingOnly=='true') {
           $dataTable->setFilter(Project::tableName() . '.status="' . Project::STATUS_INPROGRESS . '"  OR '
               . Project::tableName() . '.status="' . Project::STATUS_DONE . '" AND ' . Project::tableName() . '.date_end>"' . date('Y-m-d') . '" OR '
               . Project::tableName() . '.status="' . Project::STATUS_ONHOLD . '" AND ' . Project::tableName() . '.date_end>"' . date('Y-m-d') . '"');
        }
        
        $activeRecordsData = $dataTable->getData();
        $list = [];

        foreach ($activeRecordsData as $key => $model) {
            $developers = $model->getDevelopers()->all();
            $developersNames = [];
            foreach ($developers as $developer) {
                if($developer->is_active == 0)
                    continue;

                $dev = [
                    'id'            => $developer->id,
                    'first_name'    => $developer->first_name,
                    'last_name'     => $developer->last_name,
                    'role'          => $developer->role,
                ];
                if ($aliasUserId = ProjectDeveloper::findOne(['user_id' => $developer->id,
                    'project_id' => $model->id])->alias_user_id
                ) {
                    $aliasUser = User::find()
                        ->where('id=:alias', [
                            ':alias' => $aliasUserId])->one();

                    $dev['alias'] = [
                        'id'            => $aliasUser->id,
                        'first_name'    => $aliasUser->first_name,
                        'last_name'     => $aliasUser->last_name
                    ];
                }
                $developersNames[] = $dev;
            }

            $customers = $model->getCustomers()->all();
            $customersNames = [];

            foreach ($customers as $customer) {
                if($customer->is_active == 0)
                    continue;
                $projectCustomer = ProjectCustomer::findOne(['user_id' => $customer->id, 'project_id' => $model->id]);
                $customersNames[] = [
                    'id'                => $customer->id,
                    'first_name'        => $customer->first_name,
                    'last_name'         => $customer->last_name,
                    'receive_invoices'  => $projectCustomer->receive_invoices
                ];
            }

            $list[$key] = $this->defaultVal($model);

            if (User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_CLIENT])) {
                $list[$key] = $this->specialVal($model, $developersNames, $customersNames);
            }

            if (User::hasPermission([User::ROLE_SALES]) && ($model->isSales(Yii::$app->user->id))) {
                $list[$key] = $this->specialVal($model, $developersNames, $customersNames);
            }

            if (User::hasPermission([User::ROLE_PM]) && $model->isPm(Yii::$app->user->id)) {
                $list[$key] = $this->specialVal($model, $developersNames, $customersNames);
            }
        }

        $data = [
            "projects" => $list,
            "total_records" => DataTable::getInstance()->getTotal()
        ];
        $this->setData($data);
    }

    /**
     * @param $model Project
     * @param $developersNames
     * @param $customersNames
     * @return Array
     */
    function specialVal($model, $developersNames, $customersNames) : array
    {
        $list = $this->defaultVal($model);
        $list['is_sales']       = isset($model->getProjectDevelopers()->where(['is_sales'=> 1])->one()->user_id) ? $model->getProjectDevelopers()->where(['is_sales'=> 1])->one()->user_id : null;
        $list['is_pm']          = isset($model->getProjectDevelopers()->where(['is_pm'=> 1])->one()->user_id) ? $model->getProjectDevelopers()->where(['is_pm'=> 1])->one()->user_id : null;
        $list['total_logged']   = $model->total_logged_hours ? $model->total_logged_hours : 0;

        if (!User::hasPermission([User::ROLE_PM])) {
            $list['cost'] = '$' . number_format($model->cost, 2, ',	', '.');
            $list['total_paid'] = $model->total_paid_hours ?: 0;
        }

        if((User::hasPermission([User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_SALES, User::ROLE_FIN ])) &&
            ($projectDeveloper = $model->getProjectDevelopers()->where(['user_id' => Yii::$app->user->id])->one())) {
            if( $projectDeveloper->status == 'ACTIVE' ) {
                $list['is_subscribed']  = true;
            } else if( $projectDeveloper->status == 'INACTIVE') {
                $list['is_subscribed']  = false;
            }
        } else {

            $list['is_subscribed']  = false;
        }

        $list['total_approved'] = $model->total_approved_hours ? $model->total_approved_hours : 0;
        $list['date_start']     = $model->date_start ? date("d/m/Y", strtotime($model->date_start)) : "Date Start Not Set";
        $list['date_end']       = $newDateEnd = $model->date_end ? date("d/m/Y", strtotime($model->date_end)) : "Date End Not Set";
        $list['developers']     = $developersNames;
        $list['clients']        = $customersNames;
        $milestones = [];
        if ( $model->type == Project::TYPE_FIXED_PRICE ) {

            $milestones = Milestone::findAll(['project_id'  => $model->id]);

            $milestones = ArrayHelper::toArray($milestones, [
                'app\models\Milestone' => [
                    'id',
                    'name',
                    'start_date' => function ($item) {
                        return DateUtil::reConvertData($item->start_date);
                    },
                    'end_date' => function ($item) {
                        return DateUtil::reConvertData($item->end_date);
                    },
                    'closed_date' => function ($item) {
                        return DateUtil::reConvertData($item->closed_date);
                    },
                    'estimated_amount',
                    'status'

                ],
            ]);

        }
        $list['milestones'] = $milestones;

        return $list;
    }

    /**
     * @param $model
     * @return mixed
     */
    function defaultVal($model) : Array
    {
        $list['id'] = $model->id;
        $list['name'] = $model->name;
        $list['type'] = $model->type;
        $list['jira'] = $model->jira_code;
        $list['status'] = $model->status;

        return $list;
    }

}
