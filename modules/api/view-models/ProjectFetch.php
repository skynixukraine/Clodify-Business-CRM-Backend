<?php
/**
 * Created by Skynix Team
 * Date: 13.04.17
 * Time: 9:14
 */

namespace viewModel;

use Yii;
use app\modules\api\components\SortHelper;
use app\components\DataTable;
use app\components\DateUtil;
use app\models\Project;
use app\models\User;
use app\models\Report;
use app\models\ProjectDeveloper;
use app\models\ProjectCustomer;
use app\models\Invoice;

class ProjectFetch extends ViewModelAbstract
{

    public function define()
    {
        $order       = Yii::$app->request->getQueryParam('order', []);
        $keyword     = Yii::$app->request->getQueryParam('search_query');
        $start       = Yii::$app->request->getQueryParam('start') ?: 0;
        $limit       = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;

        if (User::hasPermission([User::ROLE_ADMIN])) {
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
                ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                ->groupBy('id');
        }
        if (User::hasPermission([User::ROLE_SALES])) {
            $query = Project::find()
                ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id="
                            . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
                ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                ->andWhere([ProjectDeveloper::tableName() . '.is_sales' => 1])
                ->groupBy('id');
        }
        if (User::hasPermission([User::ROLE_FIN, User::ROLE_CLIENT])) {
            $query = Project::find()
                ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . ".project_id="
                            . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectCustomer::tableName() . ".user_id")
                ->groupBy('id');
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

        $activeRecordsData = $dataTable->getData();
        $list = [];

        foreach ($activeRecordsData as $model) {
            $developers = $model->getDevelopers()->all();
            $developersNames = [];
            foreach ($developers as $developer) {
                if($alias_user = ProjectDeveloper::findOne(['user_id' => $developer->id,
                    'project_id' => $model->id])->alias_user_id) {
                        $aliases = User::find()
                            ->where('id=:alias', [
                                ':alias' => $alias_user])->one()->first_name . ' ' .
                        User::find()
                            ->where('id=:alias', [
                                ':alias' => $alias_user])->one()->last_name;
                        $developer->id == $alias_user ? $developersNames[] = $aliases:
                            $developersNames[] = $aliases . '(' . $developer->first_name ." ". $developer->last_name . ')';
                } else {
                    $developersNames[] = $developer->first_name . ' ' . $developer->last_name;
                }

            }
            $customers = $model->getCustomers()->all();
            $customersNames = [];

            foreach ($customers as $customer){

                $customersNames[] = $customer->first_name . " " .  $customer->last_name;
            }

            $newDateStart =$model->date_start ? date("d/m/Y", strtotime($model->date_start)): "Date Start Not Set";
            $newDateEnd = $model->date_end ? date("d/m/Y", strtotime($model->date_end)) : "Date End Not Set";
            $cost = '$' . number_format($model->cost, 2, ',	', '.');
            $list[] =
                [
                    'id' => $model->id,
                    'name' => $model->name,
                    'jira' => $model->jira_code,
                    'total_logged' => $model->total_logged_hours,
                    'cost' => $cost,
                    'total_paid' => $this->sumPaidHours($model->id),
                    'date_start' => $newDateStart,
                    'date_end' => $newDateEnd,
                    'developers' => $developersNames ? implode(", ", $developersNames): "Developer Not Set",
                    'clients' => $customersNames ? implode(", ", $customersNames): "Customer Not Set",
                    'status' => $model->status
                ];
        }

        $data = [
            "projects" => $list,
            "total_records" => DataTable::getInstance()->getTotal()
        ];
        $this->setData($data);
    }

    /**
     * @param $prodId
     * @return int
     */
    private function sumPaidHours($prodId)
    {
        $sumHoursReports = Report::find()
            ->select('hours')
            ->joinWith(['invoice'])
            ->andWhere([Invoice::tableName() . '.status' => Invoice::STATUS_PAID])
            ->andWhere([Report::tableName() . '.project_id' => $prodId])
            ->sum('hours');
        return $sumHoursReports ?: 0;
    }

}