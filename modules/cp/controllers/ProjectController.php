<?php
/**
 * Created by PhpStorm.
 * User: olha
 * Date: 01.02.16
 * Time: 14:46
 */
namespace app\modules\cp\controllers;
use app\models\Project;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\Report;
use app\models\SiteUser;
use app\models\Visit;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\DataTable;
use app\components\AccessRule;
use app\models\Site;
use app\models\Story;
use app\models\Photo;
use app\models\User;
use app\models\Language;

class ProjectController extends Controller
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
                        'actions' => [ 'index', 'find'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN],
                    ],
                    [
                        'actions' => [ 'create', 'edit', 'delete', 'activate', 'suspend', 'update'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                    [
                        'actions' => [ 'edit', 'activate', 'suspend', 'update'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_CLIENT],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     =>['get', 'post']
                ],
            ],
        ];
    }

    public function actionIndex()
    {

       /* $model = new Project();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                $model->save();
               Yii::$app->getSession()->setFlash('success', Yii::t("app", "You create project"));
                return $this->refresh();

            }
        }*/
        return $this->render('index');
    }

    public function actionFind()
    {

        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);
        $query          = Project::find()
                            ->leftJoin( ProjectCustomer::tableName(), ProjectCustomer::tableName() . ".project_id=id");

        $columns        = [
            'id',
            'name',
            'jira_code',
            'total_logged_hours',
            'total_paid_hours',
            'date_start',
            'date_end',
            'first_name',
            'first_name',
            'status'
        ];

        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'first_name', $keyword],
                ['like', 'jira_code', $keyword]
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        if ( User::hasPermission([User::ROLE_CLIENT])) {

            $dataTable->setFilter( ProjectCustomer::tableName() . ".user_id=" . Yii::$app->user->id );
        }

        if( User::hasPermission([User::ROLE_PM]) ){

            $dataTable->setFilter( ProjectCustomer::tableName() . ".user_id=" . Yii::$app->user->id );

        }

           $dataTable->setFilter('is_delete=0');



        $activeRecordsData = $dataTable->getData();
        $list = array();
        /* @var $model \app\models\Project */
        foreach ( $activeRecordsData as $model ) {

            $developers = $model->getDevelopers()->all();
            $developersNames = [];
            /*  @var $developer \app\models\User */
            foreach($developers as $developer){

                $developersNames[] = $developer->first_name;
            }
            $customers = $model->getCustomers()->all();
            $customersNames = [];
            /*  @var $customer \app\models\User */
            foreach($customers as $customer){

                $customersNames[] = $customer->first_name;
            }
            /* @var $model \app\models\Project */
            $list[] = [
                $model->id,
                $model->name,
                $model->jira_code,
                $model->total_logged_hours,
                ( User::hasPermission( [User::ROLE_PM] ) ? " - Not Available - " : $model->total_paid_hours ),
                $model->date_start,
                $model->date_end,
                implode(', ', $developersNames),
                implode(', ', $customersNames),
                $model->status
            ];
        }

        $data = array(
            "draw"              => DataTable::getInstance()->getDraw(),
            "recordsTotal"      => DataTable::getInstance()->getTotal(),
            "recordsFiltered"   => DataTable::getInstance()->getTotal(),
            "data" => $list
        );
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content = json_encode($data);
        Yii::$app->end();

    }

    public function actionDelete()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) ) {

            if (( $id = Yii::$app->request->post("id") ) ) {

                /** @var  $model Project */
                $model  = Project::findOne( $id );
                $model->is_delete = 1;
                $model->save(true, ['is_delete']);
                return json_encode([
                    "message"   => Yii::t("app", "You delete project " . $id),
                    "success"   => true
                ]);
            }

        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }
    }

    public function actionCreate()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) ) {

            $model = new Project();
            if ($model->load(Yii::$app->request->post())) {

                if ($model->validate()) {

                    $model->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You create project"));
                    return $this->refresh();

                }
            }
            return $this->render('create', ['model' => $model]);
        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }
    }

    public function actionEdit()
    {
        return $this->render('create');

    }



    public function actionActivate()
    {

    }

    public function actionSuspend()
    {

    }

}