<?php
/**
 * Created by Skynix Team
 * Date: 21.12.16
 * Time: 16:20
 */

namespace app\modules\cp\controllers;

use app\components\DateUtil;
use app\models\Report;
use yii\filters\AccessControl;
use app\models\User;
use app\components\AccessRule;
use app\models\Contract;
use Yii;
use app\components\DataTable;
use yii\filters\VerbFilter;
use app\models\Project;
use mPDF;
use app\models\Invoice;
use app\models\Storage;

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
                        'actions' => [ 'index', 'create', 'edit', 'find', 'delete', 'view', 'downloadcontract', 'downloadactofwork'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_FIN],
                    ],
                    [
                        'actions' => [ 'index', 'create', 'edit', 'find', 'view', 'downloadcontract', 'downloadactofwork'],
                        'allow' => true,
                        'roles' => [User::ROLE_SALES],
                    ],
                    [
                        'actions' => ['index', 'find', 'downloadcontract', 'downloadactofwork'],
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

            if ($model->validate() && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You created new Contract " . $model->contract_id));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionEdit()
    {
        if( ($id = Yii::$app->request->get('id')) &&
            ( $model  = Contract::findOne($id) ) ) {

            if ( Yii::$app->request->isPost &&
                    $model->load( Yii::$app->request->post() ) ) {

                if ($model->validate()) {

                    $model->save();

                    if ( ($invoice = Invoice::findOne(['contract_id' => $model->id, 'is_delete' => 0]) ) ) {

                        $invoice->contract_id     = $model->id;
                        $invoice->contract_number = $model->contract_id;
                        $invoice->act_of_work     = $model->act_number;
                        $invoice->date_start      = $model->start_date;
                        $invoice->date_end        = $model->end_date;
                        $invoice->total           = $model->total;
                        $invoice->user_id         = $model->customer_id;
                        /** Invoice - total logic */
                        if($invoice->total != null && $invoice->discount == null){

                            $invoice->discount = 0;
                            $invoice->subtotal = $invoice->total;

                        }
                        if($invoice->total !=null && $invoice->discount != null){
                            $invoice->subtotal = $invoice->total;
                            $invoice->total = ( $invoice->subtotal - $invoice->discount );

                        }
                        if ($invoice->validate() && $invoice->save()) {
                            if(Yii::$app->request->post('updated')) {
                                Yii::$app->getSession()
                                    ->setFlash('success', Yii::t("app", "You edited contract {contract_id} with related invoice {invoice_id}", [
                                        'contract_id'   => $model->contract_id,
                                        'invoice_id'    => $invoice->id
                                    ]));
                            }
                            return $this->redirect(['index']);
                        } else {

                            Yii::$app->getSession()->setFlash('error', implode("<br>", $invoice->getFirstErrors()));
                            return $this->redirect(['index']);
                        }
                    }
                    if(Yii::$app->request->post('updated')) {
                        Yii::$app->getSession()
                            ->setFlash('success',
                                    Yii::t("app", "You edited contract {contract_id}",
                                            [
                                                'contract_id' => $model->contract_id
                                            ]));
                    }
                    return $this->redirect(['index']);

                }
            }

        } else {

            Yii::$app->getSession()->setFlash('error', Yii::t("app", "The contract has not been found "));
            return $this->redirect(['index']);

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
                ['like', 'contract_id', $keyword],
                ['like', 'created_by', $keyword],
                ['like', 'customer_id', $keyword],
                ['like', 'act_number', $keyword]
            ]);
        // DateUtil::convertData() returns incoming param only if it does not match to 01/01/2017 format
        if (!empty($keyword) && ($date = DateUtil::convertData($keyword)) !== $keyword ) {
            $dataTable->setSearchParams([ 'or',
                ['like', 'start_date', $date],
                ['like', 'end_date', $date],
                ['like', 'act_date', $date],
            ]);
        }
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
            $expenses = 'Unknown';
            $user = null;
            $createdByCurrentUser = null;
            $canInvoice = null;
            $projectIDs = [];
            $initiator = User::findOne($model->created_by);
            $customer = User::findOne($model->customer_id);
            if (User::hasPermission([User::ROLE_ADMIN]) || $model->created_by == Yii::$app->user->id) {
                $createdByCurrentUser = true;
            }
            if(User::hasPermission([User::ROLE_SALES])) {
                $createdByCurrentUser = false;
            }
            if ($model->hasInvoices() && ($invoice = Invoice::findOne(['contract_id' => $model->id, 'is_delete' => 0]))
                && $invoice->status != Invoice::STATUS_CANCELED ) {
                $canInvoice = true;
                $total_hours = Yii::$app->Helper->timeLength( $invoice->total_hours * 3600);
                $expenses = '$' . (Report::getReportsCostOnInvoice($invoice->id)
                    ? Report::getReportsCostOnInvoice($invoice->id) : 0);
            }

            if (User::hasPermission([User::ROLE_CLIENT])) {
                $expenses = null;
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
                $total_hours,
                $expenses,
                $customer->id,
                $createdByCurrentUser,
                $model->id,
                $canInvoice
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

    /**
     * Delete contract for requested ID
     * @return mixed
     */
    public function actionDelete()
    {
        if ( ($id = Yii::$app->request->post("id"))  && $model  = Contract::findOne($id)  ) {
            $model->delete();
            return json_encode([
                "message"   => Yii::t("app", "You deleted contract " . $model->contract_id),
                "success"   => true
            ]);
        }
    }

    public function actionView()
    {
        $id = Yii::$app->request->get("id");
        $model = Contract::findOne($id);
        return $this->render('view', ['model' => $model,
            'title' => 'You watch contract #' . $model->contract_id]);
    }

    public function actionDownloadcontract()
    {
        $id = Yii::$app->request->get("id");
        if (!$id) {
            throw new \Exception('Invalid parameter ID');
        }

        $model = Contract::find()
            ->andWhere([Contract::tableName() . '.id' => $id])
            ->one();

        $invoice = Invoice::find()
            ->andWhere(['contract_id' => $model->id])
            ->andWhere([Invoice::tableName() . '.is_delete' => Invoice::INVOICE_NOT_DELETED])
            ->andWhere(['in', Invoice::tableName() . '.status', array(Invoice::STATUS_NEW, Invoice::STATUS_PAID)])
            ->one();

        if ($model && $invoice) {
            //-------------- Download contractor signature from Amazon Simple Storage Service--------//
            $contractor = User::findOne(Yii::$app->params['contractorId']);
            $contractorSign = 'data/' . $contractor->id . '/sign/' . $contractor->sing;

            $s = new Storage();
            $folder = Yii::getAlias('@app') . '/data/sign/';

            if (!is_dir($folder)) {
                mkdir($folder);
            }

            $conractorImgPath = $folder . '/' . 'contractor.' . pathinfo($contractor->sing, PATHINFO_EXTENSION);
            try {
                $s->downloadToFile($contractorSign, $conractorImgPath);
            } catch (\Aws\S3\Exception\S3Exception $e) {}

            //----------------Download customer signature from Amazon Simple Storage Service---------//

            $customer = User::findOne($model->customer_id);
            $customerSign = 'data/' . $customer->id . '/sign/' . $customer->sing;
            $customerImgPath = $folder . '/' . 'customer.' . pathinfo($contractor->sing, PATHINFO_EXTENSION);
            try {
                $s->downloadToFile($customerSign, $customerImgPath);
            } catch (\Aws\S3\Exception\S3Exception $e) {}

            $imgData = base64_encode(file_get_contents($conractorImgPath));
            $signatureContractor = 'data: ' . mime_content_type($conractorImgPath) . ';base64,' . $imgData;

            $imgData = base64_encode(file_get_contents($customerImgPath));
            $signatureCustomer = 'data: ' . mime_content_type($customerImgPath) . ';base64,' . $imgData;
            // Generating PDF
            $html = $this->renderPartial('contractPDF', [

                'contract_id'                => $model->contract_id,
                'start_date'                 => $model->start_date,
                'total'                      => $invoice->total,
                'contract_template_id'       => $model->contract_template_id,
                'contract_payment_method_id' => $model->contract_payment_method_id,
                'customer_id'                => $model->customer_id,
                'contractor'                 => $contractor,
                'signatureCustomer'          => $signatureCustomer,
                'signatureContractor'        => $signatureContractor
            ]);

            $pdf = new mPDF();
            @$pdf->WriteHTML($html);
            $pdf->Output($model->id . '.pdf', 'D');
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, the contract #" . $model->contract_id . " is not available for downloading."));
            return $this->redirect(['view', 'id' => $id]);
        }
    }


    public function actionDownloadactofwork()
    {
        if ( ( $id = Yii::$app->request->get("id") ) && ( $contract = Contract::findOne($id) )
            && ($contract->hasInvoices()) ) {
            $customer   = User::findOne($contract->customer_id);
            $invoice    = Invoice::find()->where(['contract_id' => $contract->id, 'is_delete' => 0])->one();
            $contractor = User::findOne(Yii::$app->params['contractorId']);

            //-------------- Download contractor signature from Amazon Simple Storage Service--------//
            $contractor = User::findOne(Yii::$app->params['contractorId']);
            $contractorSign = 'data/' . $contractor->id . '/sign/' . $contractor->sing;

            $s = new Storage();
            $folder = Yii::getAlias('@app') . '/data/sign/';

             if(!is_dir($folder)){
                mkdir($folder );
             }
            $conractorImgPath  = $folder .'/'. 'contractor.'. pathinfo( $contractor->sing, PATHINFO_EXTENSION);
               try {
                   $s->downloadToFile($contractorSign, $conractorImgPath);
               } catch (\Aws\S3\Exception\S3Exception $e) {
               }

            //----------------Download customer signature from Amazon Simple Storage Service---------//

            $customerSign = 'data/' . $customer->id . '/sign/' . $customer->sing;
            $customerImg = 'customer.'. pathinfo( $customer->sing, PATHINFO_EXTENSION);
            $customerImgPath  = $folder .'/'. 'customer.'. pathinfo( $contractor->sing, PATHINFO_EXTENSION);
            try {
                $s->downloadToFile($customerSign, $customerImgPath);
            }  catch (\Aws\S3\Exception\S3Exception $e) {}
            $imgData = base64_encode(file_get_contents($conractorImgPath));
            $signatureContractor = 'data: '.mime_content_type($conractorImgPath).';base64,'.$imgData;

            $imgData = base64_encode(file_get_contents($customerImgPath));
            $signatureCustomer = 'data: '.mime_content_type($customerImgPath).';base64,'.$imgData;

            $html = $this->renderPartial('actOfWorkPDF', [
                'contractor'          => $contractor,
                'customer'            => $customer,
                'invoice'             => $invoice,
                'contract'            => $contract,
                'signatureCustomer'   => $signatureCustomer,
                'signatureContractor' => $signatureContractor
            ]);

            $pdf = new mPDF();
            @$pdf->WriteHTML($html);
            $pdf->Output($contract->act_number . '.pdf', 'D');
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, the contact  #" . $id. " is not existed."));
            return $this->redirect(['view', 'id' => $id]);
        }
    }
}