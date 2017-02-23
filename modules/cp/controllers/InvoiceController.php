<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 16.02.16
 * Time: 11:55
 */
namespace app\modules\cp\controllers;

use app\models\Contract;
use app\models\ContractTemplates;
use app\models\Project;
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
use app\models\ProjectDeveloper;

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
                        'actions'   => ['index', 'find', 'create', 'view', 'send', 'paid', 'canceled', 'download', 'downloadreports',
                            'get-projects'
                        ],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES],
                    ],
                    [
                        'actions'   => ['index', 'find', 'view', 'download', 'downloadreports'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_CLIENT],
                    ],
                    [
                        'actions'   => ['delete', 'download', 'downloadreports'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES],
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
                    'delete'    => ['delete'],
                    'download'  => ['get', 'post'],
                    'downloadreports'=> ['get', 'post'],
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
        $query          = Invoice::find()->leftJoin(User::tableName(), Invoice::tableName() . '.user_id=' . User::tableName() . '.id' );
        $columns        = [
            'id',
            'first_name',
            'contract',
            'subtotal',
            'discount',
            'total',
            'date_created',
            'date_sent',
            'date_paid',
            'status',

        ];
        $projectIDs = [];
        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'status', $keyword],
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);
        $dataTable->setFilter(Invoice::tableName() . '.is_delete=0');

        if(User::hasPermission([User::ROLE_CLIENT])) {
            $projects = Project::find()
                ->leftJoin(  ProjectCustomer::tableName(), ProjectCustomer::tableName() . ".project_id=" . Project::tableName() . ".id")
                ->leftJoin(User::tableName(), User::tableName() . ".id=" . ProjectCustomer::tableName() . ".user_id")
                ->where([ProjectCustomer::tableName() . '.user_id' => Yii::$app->user->id])
                ->all();
            foreach ($projects as $project) {
                $projectIDs[] = $project->id;
            }
            if ($projectIDs) {
                $dataTable->setFilter(Invoice::tableName() . '.user_id=' . Yii::$app->user->id . ' OR ' . Invoice::tableName() . '.project_id IN (' . implode(',', $projectIDs) . ')');
            } else {
                $dataTable->setFilter(Invoice::tableName() . '.user_id=' . Yii::$app->user->id);
            }
        }
        if (User::hasPermission([User::ROLE_SALES])) {
            $customers = [];
            $projects = Project::find()
                ->leftJoin(  ProjectDeveloper::tableName(), ProjectDeveloper::tableName() . ".project_id=" . Project::tableName() . ".id")
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
                if ($projectCustomer) {
                    $customers[] = User::findOne($projectCustomer->user_id)->id;
                }
                $projectIDs[] = $project->id;
            }
            if ($projectIDs) {
                $dataTable->setFilter(Invoice::tableName() . '.project_id IN (' . implode(",", $projectIDs) . ') OR '
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
            // If invoice was created for 'All projects' and invoiced customer has no common projects
            // with current SALES user - go to the next record
            if (User::hasPermission([User::ROLE_SALES])) {
                if (!$model->project_id && !in_array($model->user_id, $customers)) {
                    continue;
                }
            }
            if ( $client = $model->getUser()->one() ) {
                $name = $client->first_name . ' ' . $client->last_name;
            }

            $list[] = [
                $model->id,
                $name,
                "C#" . $model->contract_number . ", Act#" . $model->act_of_work .
                    "<br> (" . $model->date_start . '~' . $model->date_end .')',
                '$' . ($model->subtotal > 0 ? $model->subtotal : 0),
                '$' . ($model->discount > 0 ? $model->discount : 0),
                '$' . ($model->total > 0 ? $model->total : 0),
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

    public function actionCreate($id = null)
    {
        $model      = new Invoice();
        $model->created_by = Yii::$app->user->id;
        $contract   = null;
        if ( $id && ( $contract = Contract::findOne( $id )) ) {
            $model->contract_id     = $contract->id;
            $model->contract_number = $contract->contract_id;
            $model->act_of_work     = $contract->act_number;
            $model->date_start      = date('d/m/Y', strtotime($contract->start_date));
            $model->date_end        = date('d/m/Y', strtotime($contract->end_date));
            $model->total           = $contract->total;
            $model->user_id         = $contract->customer_id;

        }


        if ($model->load(Yii::$app->request->post())) {

            /** Invoice - total logic */
            if($model->total != null && $model->discount == null){

                $model->discount = 0;
                $model->subtotal = $model->total;

            }
            if($model->total !=null && $model->discount != null){
                $model->subtotal = $model->total;
                $model->total = ( $model->subtotal - $model->discount );

            }

            if ($model->total_hours) {
                $model->total_hours = Yii::$app->Helper->timeLength($model->total_hours);
            }

            $model->date_created = date('Y-m-d');

            if ($model->validate() && $model->save()) {
                Yii::$app->getSession()
                            ->setFlash('success', Yii::t("app", "You created new invoice {id}", ['id' => $model->id]));
            }
            return $this->redirect(['view?id=' . $model->id]);
        }
        return $this->render('create',
                [
                    'model'     => $model,
                    'contract'  => $contract
                ]);
    }

    public function actionView()
    {
        if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES, User::ROLE_CLIENT] ) ) {
            if (($id = Yii::$app->request->get("id"))) {

                $model = Invoice::find()
                    ->where("id=:iD",
                        [
                            ':iD' => $id
                        ])
                    ->one();
            }

            $model->subtotal    = $model->subtotal > 0 ? $model->subtotal : 0;
            $model->total       = $model->total > 0 ? $model->total : 0;
            $model->discount    = $model->discount > 0 ? $model->discount : 0;

            if( User::hasPermission( [User::ROLE_CLIENT])   ) {
                //Check if the current client can see this invoice from the reports menu.
                $reportsForCurrentClient = Report::find()->leftJoin(ProjectCustomer::tableName(), ProjectCustomer::tableName() . '.project_id = reports.project_id' )
                    ->where(['reports.invoice_id' => $id])->andWhere(['project_customers.user_id'=>Yii::$app->user->id])->all();
                if( ! $reportsForCurrentClient ) {
                    /*throw new \Exception('Sorry, you are prohibited to see this page');*/
                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, you are prohibited to see this page"));
                    return $this->redirect(['index']);
                }
            }
            /** @var $model Invoice */
            return $this->render('view', ['model' => $model,
                'title' => 'You watch invoice #' . $model->id]);
        }else{
            /*throw new \Exception('Sorry, you are prohibited to see this page');*/
            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, you are prohibited to see this page"));
            return $this->redirect(['index']);

        }
    }

    public function actionSend()
    {
        $model = new Invoice();
        if($model->load(Yii::$app->request->post())) {
            if (!empty($model->id)) {

                $dataPdf = Invoice::findOne($model->id);
                /** @var $dataPdf Invoice */
                if( !empty( $dataPdf->getUser()->one()->email ) ){
                    $content = Yii::getAlias('@app') . '/data/invoices/' . $dataPdf->id . '.pdf';
                    $content2 = Yii::getAlias('@app') . '/data/invoices/reports' . $dataPdf->id . '.pdf';;

                    if ($dataPdf->status == Invoice::STATUS_NEW && $dataPdf->date_sent == null) {

                        $email = Yii::$app->mailer->compose('invoice', [

                            'id' => $dataPdf->id,
                            'nameCustomer' => $dataPdf->getUser()->one()->first_name . ' ' .
                                $dataPdf->getUser()->one()->last_name,
                            'dataFrom' => date('j F Y', strtotime($dataPdf->date_start)),
                            'dataTo' => date('j F Y', strtotime($dataPdf->date_end)),
                        ])
                            ->setSubject('Skynix Invoice #' . $dataPdf->id)
                            ->setFrom(Yii::$app->params['adminEmail'])
                            ->setTo($dataPdf->getUser()->one()->email);
                        if(Yii::$app->params['invoice_cc_email']) {

                            $email->setCc(Yii::$app->params['invoice_cc_email']);

                        }
                            //$email->setTo('valeriya@skynix.co');
                            $email->attachContent($content, ['fileName' => 'Invoice' . $dataPdf->id . '.pdf'])
                            ->attachContent($content2, ['fileName' => 'TimesheetReport-Contract' . $dataPdf->contract_number . '-Invoice'. $dataPdf->id . '.pdf'])
                            ->send();

                        $connection = Yii::$app->db;
                        $connection->createCommand()
                            ->update(Invoice::tableName(), [

                                'date_sent' => date('Y-m-d'),

                            ], 'id=:Id',
                                [
                                    ':Id' => $dataPdf->id,
                                ])
                            ->execute();
                    }
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You have sent the invoice to the client"));

                }else{

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Client does not have the email"));

                }

            }

        }
        return $this->redirect(['invoice/index']);
    }

    public function actionPaid()
    {
        if (( $id = Yii::$app->request->get("id") ) ) {

            $model = Invoice::findOne($id);
            $model->status = Invoice::STATUS_PAID;
            $model->date_paid = date('Y-m-d');
            $model->save(true, ['status', 'date_paid']);
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "You have marked the invoice " . $id . " as paid"));
            return $this->redirect(['invoice/index']);
        }
    }

    public function actionCanceled()
    {
        if (( $id = Yii::$app->request->get("id") ) ) {

            $model = Invoice::findOne($id);
            $model->status = Invoice::STATUS_CANCELED;
            $model->save(true, ['status']);
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "You canceled invoice " . $id));
            return $this->redirect(['invoice/index']);
        }
    }

    public function actionDelete()
    {
        if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_FIN] ) ) {

            if (( $id = Yii::$app->request->post("id") ) ) {

                /** @var  $model User */
                $model  = Invoice::findOne( $id );
                $model->is_delete = 1;
                $model->save(true, ['is_delete']);

                return json_encode([
                    "message"   => Yii::t("app", "Invoice # " . $id ." has been deleted "),
                ]);
            }

        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');
        }
    }

    public function actionDownload()
    {
        /** @var $model Invoice */
        if ( ( $id = Yii::$app->request->get("id") ) && ( $dataPdf = Invoice::findOne($id) ) ) {
            $contract = Contract::findOne($dataPdf->contract_id);
            $html = $this->renderPartial('invoicePDF', [

                'id' => $dataPdf->id,
                'nameCustomer' => $dataPdf->getUser()->one()->first_name . ' ' .
                    $dataPdf->getUser()->one()->last_name,
                'total' => $dataPdf->total > 0 ?$dataPdf->total:0,
                'numberContract' => $dataPdf->contract_number,
                'actWork' => $dataPdf->act_of_work,
                'dataFrom' => date('j F', strtotime($dataPdf->date_start)),
                'dataTo' => date('j F', strtotime($dataPdf->date_end)),
                'dataFromUkr' => date('d.m.Y', strtotime($dataPdf->date_start)),
                'dataToUkr' => date('d.m.Y', strtotime($dataPdf->date_end)),
                'paymentMethod' => PaymentMethod::findOne($contract->contract_payment_method_id),
                'idCustomer' => $dataPdf->getUser()->one()->id,
                'notes'      => $dataPdf->note,
                'sing'       => $dataPdf->getUser()->one()->sing,
                'contractor' => User::findOne(Yii::$app->params['contractorId'])

            ]);

            $pdf = new mPDF();
            $pdf->WriteHTML($html);
            $pdf->Output('../data/invoices/' . $dataPdf->id . '.pdf', 'F');
            if( ( $dataPdf->user_id == Yii::$app->user->id &&
                 User::hasPermission([User::ROLE_CLIENT]) ) ||
                 User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ){

                if (file_exists($path = Yii::getAlias('@app/data/invoices/' . $id . '.pdf'))) {

                        header("Content-type:application/pdf"); //for pdf file
                        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
                        header('Content-Length: ' . filesize($path));
                        readfile($path);
                        Yii::$app->end();

                } else {

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, this seems like this PDF invoice was deleted."));
                    return $this->redirect(['view', 'id' => $id]);
                }
            } else {

                Yii::$app->getSession()->setFlash('error', Yii::t("app", "Ooops, you do not have priviledes for this action."));
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {

            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, but this page does not exist."));
            return $this->redirect(['index']);
        }

    }
    public function actionDownloadreports()
    {
        /** @var $model Invoice */
        if ( ( $id = Yii::$app->request->get("id") ) && ( $model = Invoice::findOne($id) ) ) {
            $r = Invoice::report($model->user_id, $model->date_start, $model->date_end);
            $html2 = $this->renderPartial('invoiceReportPDF', [
                'model' => $model,
                'id' => $model->id,
                'r'  => $r,

            ]);
            $pdf = new mPDF();
            $pdf->WriteHTML($html2);
            $pdf->Output('../data/invoices/' . 'reports' . $model->id . '.pdf', 'F');
            if( ( $model->user_id == Yii::$app->user->id &&
                    User::hasPermission([User::ROLE_CLIENT]) ) ||
                User::hasPermission([User::ROLE_ADMIN, User::ROLE_FIN]) ){

                if (file_exists($path = Yii::getAlias('@app/data/invoices/' . 'reports'. $id . '.pdf'))) {
                    /*$this->downloadFile($path);*/

                    header("Content-type:application/pdf"); //for pdf file
                    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
                    header('Content-Length: ' . filesize($path));
                    readfile($path);
                    Yii::$app->end();

                } else {

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, this seems like this PDF invoice was deleted."));
                    return $this->redirect(['view', 'id' => $id]);
                }
            } else {

                Yii::$app->getSession()->setFlash('error', Yii::t("app", "Ooops, you do not have priviledes for this action."));
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {

            Yii::$app->getSession()->setFlash('error', Yii::t("app", "Sorry, but this page does not exist."));
            return $this->redirect(['index']);
        }

    }

    public function actionGetProjects()
    {
        if ($customer = Yii::$app->request->getQueryParam('customer')) {
            $data[] = [
                'id' => '',             // zero element of dropdown list
                'name' => 'Choose...'];
            if ($projects = Project::ProjectsCurrentClient($customer)) {
                foreach ($projects as $project) {
                    $data[] = [
                        'id'    => $project->id,
                        'name'  => $project->name
                    ];
                }
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->content = json_encode($data);
        }
    }

}