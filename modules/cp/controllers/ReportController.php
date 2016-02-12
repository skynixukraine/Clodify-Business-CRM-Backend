<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 09.02.16
 * Time: 16:34
 */
namespace app\modules\cp\controllers;
use app\models\Project;
use app\models\Report;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\components\DataTable;
use app\components\DateUtil;

class ReportController extends DefaultController
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
                        'actions'   => ['index', 'find', 'edit', 'delete'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get', 'post'],
                    'find'  => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFind()
    {

        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $projectId      = Yii::$app->request->getQueryParam("project_id");
        $dateStart      = Yii::$app->request->getQueryParam("date_start");
        $dateEnd        = Yii::$app->request->getQueryParam("date_end");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);
        $query          = Report::find();
        $columns        = [
            'id',
            'task',
            'date_added',
            'name',
            'reporter_name',
            'date_report',
            'invoice_id',
        ];

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'reporter_name', $keyword],
                ['like', 'task', $keyword],
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        if($projectId && $projectId != null){

            $dataTable->setFilter('project_id=' . $projectId);
        }

        if($dateStart && $dateStart != null){

           $dataTable->setFilter('date_report >= "' . DateUtil::convertData($dateStart). '"');

        }else{

            $dataTable->setFilter('date_report >= "' . date('Y-m-d') . '"');
        }

        if($dateEnd && $dateEnd != null){

            $dataTable->setFilter('date_report <= "' . DateUtil::convertData($dateEnd). '"');

        }

        $dataTable->setFilter('is_delete=0');

        $activeRecordsData = $dataTable->getData();
        $list = [];
        /* @var $model \app\models\Report */
        foreach ( $activeRecordsData as $model ) {

            $list[] = [
                $model->id,
                $model->task,
                $model->date_added,
                $model->getProject()->one()->name,
                $model->reporter_name,
                $model->date_report,
                ( $model->invoice_id == null ? "No" : "Yes" ),
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