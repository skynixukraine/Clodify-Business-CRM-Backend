<?php
/**
 * Created by WebAIS.
 * User: Wolf
 * Date: 02.10.2015
 * Time: 10:38
 */

namespace app\modules\cp\controllers;
use app\components\DateUtil;
use app\models\Invoice;
use app\models\Project;
use app\models\Report;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use DateTime;
class IndexController extends DefaultController
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
                        'actions' => [ 'index', 'delete', 'save'],
                        'allow' => true,
                        'roles' => [User::ROLE_PM ],
                    ],
                    [
                        'actions'=>['getphoto'],
                        'allow'=>true,
                        'roles'=>[User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN],
                    ],
                    [
                        'actions' => [ 'index', 'test', 'delete', 'save'],
                        'allow' => true,
                        'roles' => [User::ROLE_DEV, User::ROLE_ADMIN],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'      => ['get', 'post'],
                    'delete'     => ['get', 'post'],
                    'save'       => ['get', 'post'],
                    'getphoto'   => ['get'],
                ],
            ],
        ];
    }

    /** Testing email */
    public function actionTest()
    {
        Yii::$app->mailer->compose('test',
            ['username' => "Oleksii"])
            ->setTo( "olha@webais.company" )
            ->setFrom( Yii::$app->params['adminEmail'])
            ->setSubject( "This is a subject of the test email" )
            ->send();
        Yii::$app->end();
    }

    public function actionIndex()
    {
        $model = new Report();
        $model->dateFilter = (Yii::$app->request->get('dateFilter', 1));
        $date = new DateTime;

        if( $model->dateFilter == 2 ) {

            $model->dateStartReport = $date->modify("last Monday")->format('d/m/Y');
            $model->dateEndReport = $date->modify("next Sunday")->format('d/m/Y');
        }
        if( $model->dateFilter == 3 ) {

            $model->dateStartReport = $date->modify("first day of this month")->format('d/m/Y');
            $model->dateEndReport = $date->modify("last day of this month")->format('d/m/Y');
        }
        if( $model->dateFilter == 4 ) {

            $model->dateEndReport = $date->modify("last day of previous month")->format('d/m/Y');
            $model->dateStartReport = $date->modify("first day of this month")->format('d/m/Y');

        }


        if( ( Yii::$app->request->isAjax &&
              Yii::$app->request->isPost &&
              ( $data = json_decode($_POST['jsonData']) ) ) ) {

            if(isset($data->id)) {

                $model = Report::findOne( $data->id );

            }
            if($data->project_id != null) {

                $model->project_id = $data->project_id;
                $model->date_report = DateUtil::convertData($data->date_report);
                $model->task = $data->task;
                $model->hours = $data->hours;
                $model->user_id = Yii::$app->user->id;


                $totalHoursOfThisDay = $model->sumHoursReportsOfThisDay(Yii::$app->user->id, $model->date_report);

                $date_end = Invoice::getInvoiceWithDateEnd($model->project_id);

                if ($date_end == null || $model->date_report == null ||
                    DateUtil::compareDates(DateUtil::reConvertData($date_end), DateUtil::reConvertData($model->date_report))
                ) {

                    if ($model->validate()) {

                        if ($totalHoursOfThisDay + $model->hours <= 12) {

                            Yii::$app->user->getIdentity()->last_name;
                            if ($model->save()) {
                                return json_encode([
                                    "success" => true,
                                    "id" => $model->id
                                ]);
                            } else {
                                return json_encode([
                                    "success" => false,
                                    "id" => $model->id,
                                    "errors" => ["field" => $model->id, "message" => "Report does not add"]
                                ]);
                            }

                        } else {
                            return json_encode([
                                "success" => false,
                                "id" => $model->id,
                                "errors" => ["field" => $model->hours, "message" => "You can not add/edit this report. Maximum total hours is 12"]
                            ]);

                        }
                    } else {
                        return json_encode([
                            "success" => false,
                            "id" => $model->id,
                            "errors" => ["field" => $model->id, "message" => "Data is not valid!"]
                        ]);
                    }
                } else {

                    return json_encode([
                        "success" => false,
                        "id" => $model->id,
                        "errors" => ["field" => $model->id, "message" => "The invoice has been created on this project"]
                    ]);
                }

            }  else {

                return json_encode([
                    "success" => false,
                    "id" => $model->id,
                    "errors" => ["field" => 'project_id', "message" => "Please choose a project"]
                ]);
            }
        }
        return $this->render('index', ['model' => $model]);
    }

    /** Delete developer`s report */
    public function actionDelete()    {

        if( ( Yii::$app->request->isAjax &&
            Yii::$app->request->isPost &&
            ( $data = json_decode($_POST['jsonData']) ) &&
             isset($data->id) ) ) {

            /** @var  $model  Report*/
            $model = Report::findOne( $data->id );

            if($model->invoice_id == null) {

                $model->is_delete = 1;
                if($model->save(true, ['is_delete'])) {

                    return json_encode([
                        "success" => true,
                        "id"      => $model->id
                    ]);
                } else {
                    return json_encode([
                        "success" => false,
                        "id"      => $model->id,
                        "errors"  => [ "field" =>  $model->project_id, "message" => "Data is not valid" ]
                    ]);
                }
            }else{

                return json_encode([
                    "success" => false,
                    "id"      => $model->id,
                    "errors"  => [ "field" =>  $model->id, "message" => "You can't delete this report as invoice has been generated" ]
                ]);
            }

        }
    }

    /** Add new report */
    public function actionSave()
    {
        if( ( Yii::$app->request->isAjax &&
              Yii::$app->request->isPost &&
            ( $reportId = Yii::$app->request->post('id') ) &&
            ( $task = Yii::$app->request->post('task') ) &&
            ( $hours = Yii::$app->request->post('hours') ) &&
            ( $lastH = Yii::$app->request->post('lastH') ) &&
            ( $date = Yii::$app->request->post('date') )) || true ){

            $model = Report::findOne( $reportId );
            $model->dateFilter = (Yii::$app->request->get('dateFilter', 1));
            /** @var  $model Report */
            $totalHoursOfThisDay = $model->sumHoursReportsOfThisDay(Yii::$app->user->id, $date);
            $totalHoursOfThisDay = $totalHoursOfThisDay - $lastH;
            
            if( $model->id == $reportId ) {

                /** @var $model Report */
                $model->id = $reportId;
                $model->task = $task;
                $model->hours = $hours;



                if( $totalHoursOfThisDay + $hours <= 12 ) {

                    if ($model->save(true, ['id', 'task', 'hours'])) {

                        echo json_encode([
                            "success" => true
                        ]);
                    } else {

                        echo json_encode([
                            "success" => false
                        ]);
                    }
                }else{
                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "You can not add this report.
                                                                            Maximum total hours is 12"));
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('index');
    }

    public function actionGetphoto()
    {
        $entry = Yii::$app->getRequest()->get('entry');
        $filename = realpath($entry);

        $file_extension = strtolower(substr(strrchr($filename,"."),1));

        switch ($file_extension) {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpe": case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            default: $ctype="application/force-download";
        }

        if (!file_exists($filename)) {
            die("NO FILE HERE");
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header("Content-Type: $ctype");
        header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".@filesize($filename));
        set_time_limit(0);
        @readfile("$filename") or die("File not found.");
    }



}