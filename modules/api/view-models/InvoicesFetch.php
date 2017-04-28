<?php
/**
 * Created by Skynix Team
 * Date: 21.04.17
 * Time: 17:35
 */

namespace viewModel;

use Yii;
use app\models\User;
use app\models\Project;
use app\models\Invoice;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\components\DataTable;
use app\modules\api\components\SortHelper;

class InvoicesFetch extends ViewModelAbstract
{
    public function define()
    {
        $order = Yii::$app->request->getQueryParam("order");
        $search = Yii::$app->request->getQueryParam("search");
        $keyword = ( !empty($search['value']) ? $search['value'] : null);
        $start = Yii::$app->request->getQueryParam('start') ?: 0;
        $limit = Yii::$app->request->getQueryParam('limit') ?: SortHelper::DEFAULT_LIMIT;
        $query = Invoice::find()
                ->leftJoin(User::tableName(), Invoice::tableName() . '.user_id=' . User::tableName() . '.id' );

        $projectIDs = [];
        $dataTable = DataTable::getInstance()
            ->setQuery($query)
            ->setLimit($limit)
            ->setStart($start)
            ->setSearchValue($keyword) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'status', $keyword],
            ]);

        if ($order) {
            foreach ($order as $name => $value) {
                $dataTable->setOrder(Invoice::tableName() . '.' . $name, $value);
            }

        } else {
            $dataTable->setOrder( Invoice::tableName() . '.id', 'asc');
        }

        $dataTable->setFilter(Invoice::tableName() . '.is_delete=0');

        if(User::hasPermission([User::ROLE_CLIENT])) {
            $projects = Project::find()
                ->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . ".project_id="
                           . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectCustomer::tableName() . ".user_id")
                ->where([ProjectCustomer::tableName() . '.user_id' => Yii::$app->user->id])
                ->all();
            foreach ($projects as $project) {
                $projectIDs[] = $project->id;
            }
            if ($projectIDs) {
                $dataTable->setFilter(Invoice::tableName() . '.user_id=' . Yii::$app->user->id . ' OR '
                                      . Invoice::tableName() . '.project_id IN (' . implode(',', $projectIDs) . ')');
            } else {
                $dataTable->setFilter(Invoice::tableName() . '.user_id=' . Yii::$app->user->id);
            }
        }
        $customers = [];
        $sales = [];
        if (User::hasPermission([User::ROLE_SALES])) {
            $projects = Project::find()
                ->leftJoin(ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id="
                           . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectDeveloper::tableName() . ".user_id")
                ->where([ProjectDeveloper::tableName() . '.user_id' => Yii::$app->user->id])
                ->andWhere([Project::tableName() . '.is_delete' => 0])
                ->groupBy('id')
                ->all();
            foreach ($projects as $project) {
                $projectCustomer = ProjectCustomer::find()
                    ->where([ProjectCustomer::tableName() . '.project_id' => $project->id])
                    ->andWhere([ProjectCustomer::tableName() . '.receive_invoices' => 1])
                    ->one();
                $projectSales = ProjectDeveloper::getSalesOnProject($project->id);
                if ($projectCustomer) {
                    $customers[] = User::findOne($projectCustomer->user_id)->id;
                }
                if ($projectSales) {
                    $sales[] = User::findOne($projectSales->user_id)->id;
                }
                $projectIDs[] = $project->id;
            }
            if ($projectIDs) {
                $dataTable->setFilter(Invoice::tableName() . '.project_id IN ('
                                      . implode(",", $projectIDs) . ') OR '
                                      . Invoice::tableName() . '.project_id IS NULL');
            } else {
                $dataTable->setFilter(Invoice::tableName() . '.project_id IS NULL');
            }
        }
        $activeRecordsData = $dataTable->getData();
        $list = [];
        /** @var  $model Invoice*/
        foreach ( $activeRecordsData as $model ) {
            $name = null;
            $id = null;
            /**
             * If invoice was created for 'All projects' and invoiced customer has no common projects
             * with current SALES user - go to the next record.
             * Same logic when another SALES user creating invoice and has no common projects with us.
             */
            if (User::hasPermission([User::ROLE_SALES])) {
                if (!$model->project_id
                    && ( !in_array($model->user_id, $customers)
                        || !in_array($model->created_by, $sales))) {
                    continue;
                }
            }
            if ($client = $model->getUser()->one()) {
                $name = $client->first_name . ' ' . $client->last_name;
                $id = $client->id;
            }

            $list[] = [
                'invoice_id' =>$model->id,
                'customer' => [
                    'id' => $id,
                    'name' => $name
                ],
                'subtotal' => '$' . $model->subtotal > 0 ?: 0,
                'discount' => '$' . $model->discount > 0 ?: 0,
                'total' => '$' . $model->total > 0 ?: 0,
                'created_date' => $model->date_created,
                'sent_date' => $model->date_sent,
                'paid_date' => $model->date_paid,
                'status' => $model->status
            ];

        }

        $data = [
            'invoices' => $list,
            'total_records' => DataTable::getInstance()->getTotal(),
        ];
        $this->setData($data);
    }
}