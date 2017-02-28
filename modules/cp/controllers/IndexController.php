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
use Silex;
use Atlassian;
use yii\log\Logger;

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
                        'actions'=>['getphoto'],
                        'allow'=>true,
                        'roles'=>[User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_SALES ],
                    ],
                    [
                        'actions' => [ 'index', 'test', 'delete', 'save'],
                        'allow' => true,
                        'roles' => [User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_SALES, User::ROLE_PM],
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
    /*public function actionTest()
    {
        Yii::$app->mailer->compose('test',
            ['username' => "Oleksii"])
            ->setTo( "olha@webais.company" )
            ->setFrom( Yii::$app->params['adminEmail'])
            ->setSubject( "This is a subject of the test email" )
            ->send();
        Yii::$app->end();
    }*/
    public function actionTest  ()
    {
        // unknown error with routing.  OAuth source here http://goo.gl/2S998t   Original URL: bitbucket.org/atlassian_tutorial/atlassian-oauth-examples/src/0c6b54f6fefe996535fb0bdb87ad937e5ffc402d/php
        $app = new Silex\Application();
        $app['debug'] = true;
        $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__ . '/../views',
        ));
        $app->register(new Silex\Provider\SessionServiceProvider());
        $app->register(new Silex\Provider\UrlGeneratorServiceProvider());



        $app['oauth'] = $app->share(function() use($app){
            $oauth = new Atlassian\OAuthWrapper('http://skynix.local');
            $oauth->setPrivateKey('/home/dmytro/myrsakey.pem')
                ->setConsumerKey('SDJCS632X')
                ->setConsumerSecret('Hxh8sw00xsh6F')
                ->setRequestTokenUrl('http://jira.skynix.company:8070/plugins/servlet/oauth/request-token')
                ->setAuthorizationUrl('http://jira.skynix.company:8070/plugins/servlet/oauth/authorize?oauth_token=%s')
                ->setAccessTokenUrl('http://jira.skynix.company:8070/plugins/servlet/oauth/access-token')
                ->setCallbackUrl(
                    $app['url_generator']->generate('callback', array(), true)
                );
            ;
            return $oauth;
        });
        $app->get('/', function() use($app){
            $oauth = $app['session']->get('oauth');

            if (empty($oauth)) {
                $priorities = null;
            } else {
                $priorities = $app['oauth']->getClient(
                    $oauth['oauth_token'],
                    $oauth['oauth_token_secret']
                )->get('rest/api/2/priority')->send()->json();
            }

            return $app['twig']->render('layout.twig', array(
                'oauth' => $oauth,
                'priorities' => $priorities,
            ));
        })->bind('home');

        $app->get('/connect', function() use($app){
            $token = $app['oauth']->requestTempCredentials();

            $app['session']->set('oauth', $token);

            return $app->redirect(
                $app['oauth']->makeAuthUrl()
            );
        })->bind('connect');

        $app->get('/callback', function() use($app){
            $verifier = $app['request']->get('oauth_verifier');

            if (empty($verifier)) {
                throw new \InvalidArgumentException("There was no oauth verifier in the request");
            }

            $tempToken = $app['session']->get('oauth');

            $token = $app['oauth']->requestAuthCredentials(
                $tempToken['oauth_token'],
                $tempToken['oauth_token_secret'],
                $verifier
            );

            $app['session']->set('oauth', $token);

            return $app->redirect(
                $app['url_generator']->generate('home')
            );
        })->bind('callback');

        $app->get('/reset', function() use($app){
            $app['session']->set('oauth', null);

            return $app->redirect(
                $app['url_generator']->generate('home')
            );
        })->bind('reset');

        $app->run();
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
            Yii::$app->request->isPost ) ) {
            if ($data = json_decode($_POST['jsonData'])) {

                if (isset($data->id)) {

                    $model = Report::findOne($data->id);
                    if ($model->is_delete == 0) {
                        $oldhours = $model->hours;
                    } else {
                        $oldhours = 0;
                    }

                } else {

                    $oldhours = 0;
                }

                if ($data->project_id != null) {

                    $model->hours = $data->hours;
                    $model->project_id = $data->project_id;
                    $model->date_report = DateUtil::convertData($data->date_report);
                    $model->task = $data->task;
                    $model->user_id = Yii::$app->user->id;

                    $totalHoursOfThisDay = $model->sumHoursReportsOfThisDay(Yii::$app->user->id, $model->date_report);
                    $project = Project::findOne($model->project_id);

                    if (in_array($project->status, [Project::STATUS_INPROGRESS, Project::STATUS_ONHOLD])) {

                        $date_end = Invoice::getInvoiceWithDateEnd($model->project_id);
                        $dte = Project::findOne(['id' => $model->project_id])->date_start;
                        //var_dump(strtotime($dte));die();
                        //var_dump($dte . ' ' . $model->date_report);die();
                        if (DateUtil::compareDates(DateUtil::reConvertData($model->date_report), DateUtil::reConvertData($dte))) {

                            return json_encode([
                                "success" => false,
                                "id" => $model->id,
                                "errors" => ["field" => 'hours', "message" => "Date report can not be earlier then project's date start"]
                            ]);
                        }
                        if ((!$model->invoice_id || ($model->invoice_id && $model->getProject()->one()->is_delete == 0)) && ($date_end == null || $model->date_report == null ||
                                DateUtil::compareDates(DateUtil::reConvertData($date_end), DateUtil::reConvertData($model->date_report)))
                        ) {
                            if ($model->hours < 0.1) {

                                return json_encode([
                                    "success" => false,
                                    "id" => $model->id,
                                    "errors" => ["field" => 'hours', "message" => "hours must be at least 0.1"]
                                ]);
                            }
                            if (strlen(trim($model->task)) <= 19) {

                                return json_encode([
                                    "success" => false,
                                    "id" => $model->id,
                                    "errors" => ["field" => 'task', "message" => "Task should contain at least 20 characters."]
                                ]);
                            }
                            if ($model->validate()) {
                                $user = User::findOne(Yii::$app->user->id);
                                $model->cost = $model->hours * ($user->salary / Report::SALARY_HOURS);
                                if (($result = $totalHoursOfThisDay - $oldhours + $model->hours) <= 12) {
                                    Yii::$app->user->getIdentity()->last_name;
                                    if ($model->save()) {
                                        if ($project->validate()) {
                                            $project->save(true, ["total_logged_hours", "total_paid_hours"]);
                                        }
                                        if ($model->hours >= 0.1) {
                                            return json_encode([
                                                "success" => true,
                                                "id" => $model->id
                                            ]);
                                        }
                                        if (trim(strlen($model->task)) > 20) {
                                            return json_encode([
                                                "success" => true,
                                                "id" => $model->id
                                            ]);
                                        }

                                    } else {
                                        Yii::getLogger()->log($model->getErrors(), Logger::LEVEL_ERROR);
                                        return json_encode([
                                            "success" => false,
                                            "id" => $model->id,
                                            "errors" => ["field" => $model->id, "message" => "Report can not be saved"]
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
                                Yii::getLogger()->log($model->getErrors(), Logger::LEVEL_ERROR);
                                return json_encode([
                                    "success" => false,
                                    "id" => $model->id,
                                    "errors" => ["field" => $model->id, "message" => implode(' ',$model->getFirstErrors())]
                                ]);
                            }
                        } else {

                            return json_encode([
                                "success" => false,
                                "id" => $model->id,
                                "errors" => ["field" => $model->id, "message" => "The invoice has been created on this project"]
                            ]);
                        }
                    } else {
                        Yii::getLogger()->log('returns false if (in_array($project->status, [Project::STATUS_INPROGRESS, Project::STATUS_ONHOLD]))', Logger::LEVEL_ERROR);
                        return json_encode([
                            "success" => false,
                            "id" => $model->id,
                            "errors" => ["field" => 'project_id', "message" => "Project is not active yet"]
                        ]);
                    }
                } else {

                    return json_encode([
                        "success" => false,
                        "id" => $model->id,
                        "errors" => ["field" => 'project_id', "message" => "Please choose a project"]
                    ]);
                }
            } else {
                return json_encode([
                    "success" => false,
                    "errors" => ["message" => "can not read data"]
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

            if(($model->invoice_id == null) || ($model->invoice_id && $model->getInvoice()->one()->is_delete == 1)) {

                $model->is_delete = 1;
                if($model->save(true, ['is_delete']) && $model->hoursDelete()) {
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
            $project = Project::getProjectDevelopers()->one();

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
                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "You can not add  this report.
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