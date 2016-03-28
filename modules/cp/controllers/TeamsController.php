<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 21.03.16
 * Time: 15:41
 */
namespace app\modules\cp\controllers;
use app\components\DateUtil;
use app\models\Project;
use app\models\ProjectCustomer;
use app\models\ProjectDeveloper;
use app\models\Team;
use app\models\Teammate;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\components\DataTable;

class TeamsController extends DefaultController
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
                        'actions'   => [ 'index'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_DEV, User::ROLE_PM],
                    ],
                    [
                        'actions'   => [ 'find'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_DEV, User::ROLE_PM, User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get'],
                    'find'      => ['get'],

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
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);


        $query = Team::find()->leftJoin(User::tableName(), Team::tableName() . '.user_id=' . User::tableName() . '.id');

        $columns        = [
            'user_id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'project_id',
        ];
        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'id', $keyword],
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        if ( $teamId = Yii::$app->request->get("id") ){
            $dataTable->setFilter(Team::tableName() . '.id=' . $teamId);
        }

        $dataTable->setFilter('is_deleted=0');

        $activeRecordsData = $dataTable->getData();
        $list = array();
        /* @var $model \app\models\Team */
        foreach ( $activeRecordsData as $model ) {

            $projects = Project::projectsName($model->user_id);
            $project = [];
            foreach ($projects as $item) {
                $project[] = $item->name;
            }

            $list[] = [
                $model->user_id,
                $model->getUser()->one()->first_name,
                $model->getUser()->one()->last_name,
                $model->getUser()->one()->email,
                $model->getUser()->one()->phone,
                implode(', ', $project),
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