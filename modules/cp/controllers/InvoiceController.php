<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 16.02.16
 * Time: 11:55
 */
namespace app\modules\cp\controllers;

use app\models\Report;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\components\DataTable;
use app\components\DateUtil;
use app\models\Invoice;
use app\models\User;
use app\models\ProjectCustomer;

class InvoiceController extends DefaultController
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
                        'actions'   => ['index', 'find', 'create'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_FIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get', 'post'],
                    'find'  => ['get', 'post'],
                    'create'    => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /** Value table (Invoices in index) fields, filters, search */
    public function actionFind()
    {

        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);
        $query          = Invoice::find();

        $columns        = [
            'id',
            'first_name',
            'subtotal',
            'discount',
            'total',
            'date_start',
            'date_end',
            'date_created',
            'date_sent',
            'date_paid',
            'status'
        ];

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'status', $keyword],
            ]);


        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);
       // $dataTable->setFilter('is_delete=0');

        $activeRecordsData = $dataTable->getData();
        $list = [];

            /* @var $model \app\models\Invoice */
        foreach ( $activeRecordsData as $model ) {

            $list[] = [
                $model->id,
                $model->getUser()->one()->first_name,
                $model->subtotal,
                $model->discount,
                $model->total,
                $model->date_start,
                $model->date_end,
                $model->date_created,
                $model->date_sent,
                $model->date_paid,
                $model->status
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

    public function actionCreate()
    {
        $model = new Invoice();

        if($model->load(Yii::$app->request->post())){

            if($model->validate()){

                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You created new invoices " . $model->id));
            }
            return $this->redirect('index');
        }
        return $this->render('create', ['model' => $model]);
    }

}