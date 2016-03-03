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
                        'actions' => [ 'index' ],
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
        if ( $model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->id;
            if( $model->validate() ) {

                $model->total = $model->total + $model->hours;

                if( $model->total <= 12 ) {

                    Yii::$app->user->getIdentity()->last_name;
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You report has been added"));
                    return $this->refresh();
                }else{
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You can not add this report.
                                                                                Maximum total hours is 12"));
                    return $this->render('index',['model' => $model]);
                }
            }
        }
        return $this->render('index',['model' => $model]);
    }

    /** Delete developer`s report */
    public function actionDelete()
    {
        if( User::hasPermission( [User::ROLE_DEV, User::ROLE_ADMIN, User::ROLE_PM ] ) ){

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
        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }
        Yii::$app->end();
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

            $model = Report::getToDaysReports(Yii::$app->user->id);

            foreach ( $model as $models ) {

                if( $models->id == $reportId ) {

                    /** @var $model Report */
                    $models->id = $reportId;
                    $models->task = $task;
                    $models->hours = $hours;
                    $total = $total + $hours;

                    if( $total < 13 ) {

                        if ($models->save(true, ['id', 'task', 'hours'])) {

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
        }
        return $this->redirect(['index']);
    }



}