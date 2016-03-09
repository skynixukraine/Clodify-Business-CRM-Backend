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
use app\models\PaymentMethod;
use mPDF;

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
                        'actions'   => ['index', 'find', 'create', 'view', 'send', 'paid', 'canceled'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_FIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get', 'post'],
                    'find'      => ['get', 'post'],
                    'create'    => ['get', 'post'],
                    'view'      => ['get', 'post'],
                    'send'      => ['get', 'post'],
                    'paid'      => ['get', 'post'],
                    'canceled'  => ['get', 'post'],
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
            return $this->redirect('view?id=' . $model->id);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionView()
    {
        if (( $id = Yii::$app->request->get("id") ) ) {

            $model = Invoice::find()
                ->where("id=:iD",
                    [
                        ':iD' => $id
                    ])
                ->one();
        }
        /** @var $model Invoice */
        return $this->render('view', ['model' => $model,
                                      'title' => 'You watch invoice #' . $model->id]);
    }

    public function actionSend()
    {
        $model = new Invoice();
        if($model->load(Yii::$app->request->post())) {

           if ( !empty( $model->id ) && !empty($model->method) ) {

                $dataPdf = Invoice::find()
                    ->where("id=:iD",
                        [
                            ':iD' => $model->id,
                        ])
                    ->one();

                /** @var $dataPdf Invoice */
                if( $dataPdf->status == Invoice::STATUS_NEW && $dataPdf->date_sent == null) {


                    $html = $this->renderPartial('invoicePDF', [

                        'id'            => $dataPdf->id,
                        'nameCustomer'  => $dataPdf->getUser()->one()->first_name . ' ' . $dataPdf->getUser()->one()->last_name,
                        'total'         => $dataPdf->total,
                        'numberContract'=> $dataPdf->contract_number,
                        'actWork'       => $dataPdf->act_of_work,
                        'dataFrom'      => date('j F', strtotime($dataPdf->date_start)),
                        'dataTo'        => date('j F', strtotime($dataPdf->date_end)),
                        'dataFromUkr'   => date('d.m.Y', strtotime($dataPdf->date_start)),
                        'dataToUkr'     => date('d.m.Y', strtotime($dataPdf->date_end)),
                        'paymentMethod' => PaymentMethod::findOne(['id' => $model->method])->description,
                        'idCustomer'    => $dataPdf->getUser()->one()->id,

                    ]);

                    $pdf = new mPDF();
                    $pdf->WriteHTML($html);
                    $content = $pdf->Output('', 'S');

                    Yii::$app->mailer->compose('invoice', [

                        'id'            => $dataPdf->id,
                        'nameCustomer'  => $dataPdf->getUser()->one()->first_name . ' ' . $dataPdf->getUser()->one()->last_name,

                    ])
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($dataPdf->getUser()->one()->email)
                    ->setCc(Yii::$app->params['adminEmail'])
                    ->attachContent($content, ['fileName' => 'Invoice.pdf'])
                    ->send();

                    $connection = Yii::$app->db;
                    $connection->createCommand()
                                ->update(Invoice::tableName(), [

                                    'date_sent' => date('Y-m-d'),

                                ], 'id=:Id',
                                    [
                                        ':Id'    => $dataPdf->id,
                                    ])
                                ->execute();
                }
               Yii::$app->getSession()->setFlash('success', Yii::t("app", "You sent information about invoice"));
            }else {

               Yii::$app->getSession()->setFlash('success', Yii::t("app", "You DONT sent information about invoice.
                                                                        Choose the pay method!"));
           }
        }
        return $this->redirect(['invoice/index']);
    }

    public function actionPaid()
    {
        if (( $id = Yii::$app->request->get("id") ) ) {

            $model = Invoice::find()
                ->where("id=:iD",
                    [
                        ':iD' => $id
                    ])
                ->one();
            $model->status = Invoice::STATUS_PAID;
            $model->date_paid = date('Y-m-d');
            $model->save(true, ['status', 'date_paid']);
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "You paid invoice " . $id));
            return $this->redirect(['invoice/index']);
        }
    }

    public function actionCanceled()
    {
        if (( $id = Yii::$app->request->get("id") ) ) {

            $model = Invoice::find()
                ->where("id=:iD",
                    [
                        ':iD' => $id
                    ])
                ->one();
            $model->status = Invoice::STATUS_CANCELED;
            $model->save(true, ['status']);
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "You canceled invoice " . $id));
            return $this->redirect(['invoice/index']);
        }
    }

}