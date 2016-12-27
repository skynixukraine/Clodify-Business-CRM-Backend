<?php
/**
 * Created by Skynix Team
 * Date: 21.12.16
 * Time: 16:20
 */

namespace app\modules\cp\controllers;

use yii\filters\AccessControl;
use app\models\User;
use app\components\AccessRule;
use app\models\Contract;
use Yii;
use app\components\DataTable;

class ContractController extends DefaultController
{
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
                        'actions' => [ 'index', 'create', 'edit', 'find'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES ],
                    ],
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
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You created new Contract " . $model->id));
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionEdit()
    {
        if( $id = Yii::$app->request->get('id') ) {
            $model  = Contract::findOne($id);
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
        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);

        $query = Contract::find()
            ->groupBy('id');

        $columns = [
            'id',
            'initator',
            'customer',
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
                ['like', 'initator', $keyword],
                ['like', 'customer', $keyword],
                ['like', 'act_number', $keyword],
                ['like', 'start_date', $keyword],
                ['like', 'end_date', $keyword],
                ['like', 'act_date', $keyword],
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        $activeRecordsData = $dataTable->getData();
        $list = [];
        /* @var $model Contract*/
        foreach ($activeRecordsData as $model) {
            $initiator = User::findOne($model->created_by);
            $customer = User::findOne($model->customer_id);
            $list[] = [
                $model->id,
                $initiator->first_name . ' ' . $initiator->last_name,
                $customer->first_name . ' ' . $customer->last_name,
                $model->act_number,
                $model->start_date,
                $model->end_date,
                $model->act_date,
                $model->total,
                'total_hours_value',
                'expenses_value'
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

}