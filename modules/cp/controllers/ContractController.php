<?php
/**
 * Created by Skynix Team
 * Date: 21.12.16
 * Time: 16:20
 */

namespace app\modules\cp\controllers;

use app\models\Report;
use yii\filters\AccessControl;
use app\models\User;
use app\components\AccessRule;
use app\models\Contract;
use Yii;
use app\components\DataTable;
use yii\filters\VerbFilter;
use app\models\Project;

class ContractController extends DefaultController
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
                        'actions' => [ 'index', 'create', 'edit', 'find', 'delete', 'view'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_FIN],
                    ],
                    [
                        'actions' => [ 'index', 'create', 'edit', 'find', 'view'],
                        'allow' => true,
                        'roles' => [User::ROLE_SALES],
                    ],
                    [
                        'actions' => ['index', 'find'],
                        'allow' => true,
                        'roles' => [User::ROLE_CLIENT]
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'    => ['delete'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $model = new Contract();
        $model->created_by = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You created new Contract " . $model->contract_id));
                return $this->redirect(['view?id=' . $model->contract_id]);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionEdit()
    {
        if( $id = Yii::$app->request->get('id') ) {
            $model  = Contract::findOne(['contract_id' => $id]);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->save();
                    if(Yii::$app->request->post('updated')) {
                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "You edited contract " . $id));
                    }
                    return $this->redirect(['index']);

                }
            }
        }
        return $this->render('create', ['model' => $model]
        );
    }

    public function actionFind()
    {
        $customerId     = Yii::$app->request->getQueryParam("customer_id");
        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);

        $query = Contract::find()
            ->groupBy('id');


        $columns = [
            'id',
            'created_by',
            'customer_id',
            'act_number',
            'start_date',
            'end_date',
            'act_date',
            'total',
            'total_hours',
            'expenses'
        ];

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'id', $keyword],
                ['like', 'created_by', $keyword],
                ['like', 'customer_id', $keyword],
                ['like', 'act_number', $keyword],
                ['like', 'start_date', $keyword],
                ['like', 'end_date', $keyword],
                ['like', 'act_date', $keyword],
            ]);
        if($customerId && $customerId != null){

            $dataTable->setFilter('customer_id=' . $customerId);
        }
        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);
        if (User::hasPermission([User::ROLE_SALES])) {
            $dataTable->setFilter(Contract::tableName() . '.created_by=' . Yii::$app->user->id);
        }
        if (User::hasPermission([User::ROLE_CLIENT])) {
            $dataTable->setFilter((Contract::tableName() . '.customer_id=' . Yii::$app->user->id));
        }
        $activeRecordsData = $dataTable->getData();
        $list = [];
        /* @var $model Contract*/
        foreach ($activeRecordsData as $model) {
            $total_hours = 0;
            $expenses = 0;
            $user = null;
            $createdByCurrentUser = null;
            $projectIDs = [];
            $initiator = User::findOne($model->created_by);
            $customer = User::findOne($model->customer_id);
            $projects = Project::ProjectsCurrentClient($customer->id);
            if (User::hasPermission([User::ROLE_ADMIN]) || $model->created_by == Yii::$app->user->id) {
                $createdByCurrentUser = true;
            }
            foreach ($projects as $project) {
                $total_hours += gmdate('H:i', floor($project->total_logged_hours * 3600));
                $expenses += $project->cost;
            }

            $list[] = [
                $model->contract_id,
                $initiator->first_name . ' ' . $initiator->last_name,
                $customer->first_name . ' ' . $customer->last_name,
                $model->act_number,
                date("d/m/Y", strtotime($model->start_date)),
                date("d/m/Y", strtotime($model->end_date)),
                date("d/m/Y", strtotime($model->act_date)),
                '$' . number_format($model->total, 2),
                $total_hours . 'h',
                '$' . $expenses,
                $customer->id,
                $createdByCurrentUser
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

    public function actionDelete()
    {
        if ( ( $id = Yii::$app->request->post("id") ) ) {
            echo 1;
            /** @var  $model Contract */
            $model  = Contract::findOne(['contract_id' => $id]);
            $model->delete();
            return json_encode([
                "message"   => Yii::t("app", "You deleted contract " . $id),
                "success"   => true
            ]);
        }
    }

    public function actionView()
    {
        $id = Yii::$app->request->get("id");
        $model = Contract::findOne(['contract_id' => $id]);
        return $this->render('view', ['model' => $model,
            'title' => 'You watch contract #' . $model->contract_id]);
    }

}