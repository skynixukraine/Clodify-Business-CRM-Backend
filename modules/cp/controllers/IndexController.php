<?php
/**
 * Created by WebAIS.
 * User: Wolf
 * Date: 02.10.2015
 * Time: 10:38
 */

namespace app\modules\cp\controllers;
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
                        'actions' => [ 'index', 'delete', 'save' ],
                        'allow' => true,
                        'roles' => [User::ROLE_PM ],
                    ],
                    [
                        'actions' => [ 'index', 'test', 'delete', 'save' ],
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

        if ( $model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->id;
            if( $model->validate() ) {

                if( $model->total + $model->hours <= 12 ) {

                    Yii::$app->user->getIdentity()->last_name;
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "Your report has been added"));
                    return $this->refresh();
                }else{
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You can not add this report.
                                                                                Maximum total hours is 12"));
                    return $this->render('index',['model' => $model]);
                }
            }
        }
        return $this->render('index' ,['model' => $model]);
    }

    /** Delete developer`s report */
    public function actionDelete()
    {
        //if( User::hasPermission( [User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM ] ) ){

            if( ( $id =  Yii::$app->request->get("id") ) ){

                /** @var  $model  Report*/
                $model = Report::findOne( $id );
                if($model->invoice_id == null) {

                    $model->is_delete = 1;
                    $model->save(true, ['is_delete']);
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "Your report has been deleted"));
                    return $this->redirect(['index']);
                }else{

                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You can't delete this report as
                                                                                invoice has been generated"));
                    return $this->redirect(['index']);
                }
            }
        //}else{

        //    throw new \Exception('Ooops, you do not have priviledes for this action');

       // }
        return $this->redirect(['index']);
    }

    /** Add new report */
    public function actionSave()
    {
        if( ( Yii::$app->request->isAjax &&
              Yii::$app->request->isPost &&
            ( $reportId = Yii::$app->request->post('id') ) &&
            ( $task = Yii::$app->request->post('task') ) &&
            ( $hours = Yii::$app->request->post('hours') ) &&
            ( $total = Yii::$app->request->post('total') )) || true ){

            $model = Report::findOne( $reportId );
            $model->dateFilter = (Yii::$app->request->get('dateFilter', 1));

            if( $model->id == $reportId ) {

                /** @var $model Report */
                $model->id = $reportId;
                $model->task = $task;
                $model->hours = $hours;

                if( $total + $hours < 13 ) {

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
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You can not add this report.
                                                                            Maximum total hours is 12"));
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->redirect(['index']);
    }



}