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
use mPDF;
use app\models\Invoice;

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
                return $this->redirect(['view?id=' . $model->id]);
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
                    if ($invoice = Invoice::findOne(['contract_id' => $model->id, 'is_delete' => 0])) {
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
                                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You edited contract "
                                    . $model->contract_id . " with related invoice " . $invoice->id));
                            }
                            return $this->redirect(['index']);
                        }
                    }
                    if(Yii::$app->request->post('updated')) {
                        Yii::$app->getSession()->setFlash('success', Yii::t("app", "You edited contract " . $model->contract_id));
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
                ['like', 'contract_id', $keyword],
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
        if ( ( $id = Yii::$app->request->get("id") ) && ( $model = Contract::findOne(['contract_id' => $id]) )
            && ($model->hasInvoices()) ) {
            // Generating PDF
            $html = $this->renderPartial('contractPDF', [

                'contract_id' => $model->contract_id,
                'start_date' => $model->start_date,
                'total' => $model->total,
                'contract_template_id' => $model->contract_template_id,
                'contract_payment_method_id' => $model->contract_payment_method_id,
                'customer_id' => $model->customer_id,
                'contractor'=> User::findOne(Yii::$app->params['contractorId'])
            ]);

            $pdf = new mPDF();
            $pdf->WriteHTML($html);

            if (!is_dir('../data/contracts/')) {
                mkdir('../data/contracts/', 0777);
            }
            $pdf->Output('../data/contracts/' . $model->contract_id . '.pdf', 'F');

            if ((file_exists($path = Yii::getAlias('@app/data/contracts/' . $id . '.pdf')))) {
                header("Content-type:application/pdf"); //for pdf file
                header('Content-Disposition: attachment; filename="' . basename($path) . '"');
                header('Content-Length: ' . filesize($path));
                readfile($path);
                Yii::$app->end();
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, the contract #" . $model->contract_id . " is not available for downloading."));
            return $this->redirect(['view', 'id' => $id]);
        }
    }


    public function actionDownloadactofwork() {
        if ( ( $id = Yii::$app->request->get("id") ) && ( $contract = Contract::findOne(['contract_id' => $id]) )
            && ($contract->hasInvoices()) ) {
            $customer   = User::findOne($contract->customer_id);
            $invoice    = Invoice::find()->where(['contract_id' => $contract->id, 'is_delete' => 0])->one();
            $contractor = User::findOne(Yii::$app->params['contractorId']);

            $html = $this->renderPartial('actOfWorkPDF', [
                'contractor'=> $contractor,
                'customer'  => $customer,
                'invoice'   => $invoice,
                'contract'  => $contract
            ]);

            $pdf = new mPDF();
            $pdf->WriteHTML($html);

            if (!is_dir('../data/acts/')) {
                mkdir('../data/acts/', 0777);
            }
            $pdf->Output('../data/acts/' . $contract->act_number. '.pdf', 'F');

            if ((file_exists($path = Yii::getAlias('@app/data/acts/' . $contract->act_number . '.pdf')))) {
                header("Content-type:application/pdf"); //for pdf file
                header('Content-Disposition: attachment; filename="' . basename($path) . '"');
                header('Content-Length: ' . filesize($path));
                readfile($path);
                Yii::$app->end();
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, the contact  #" . $id. " is not existed."));
            return $this->redirect(['view', 'id' => $id]);
        }
    }
}