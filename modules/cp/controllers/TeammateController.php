<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 21.03.16
 * Time: 15:41
 */
namespace app\modules\cp\controllers;
use app\components\DateUtil;
use app\models\Team;
use app\models\Teammate;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\components\DataTable;

class TeammateController extends DefaultController
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
                        'actions'   => [ 'view', 'delete'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_FIN],
                    ],
                    [
                        'actions'   => [ 'index', 'find'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_PM, User::ROLE_DEV],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get'],
                    'find'      => ['get'],
                    'view'      => ['get', 'post'],
                    'delete'    => ['delete']

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

            $query = Team::find()->leftJoin(Teammate::tableName(), Team::tableName() . '.id=' . Teammate::tableName() . '.team_id');

        $columns        = [
            'id',
            'name',
            'user_id',
            'team_id',
            'date_created',

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

        $dataTable->setFilter('is_deleted=0');


        $activeRecordsData = $dataTable->getData();
        $list = array();
        /* @var $model \app\models\Team */
        foreach ( $activeRecordsData as $model ) {

            $list[] = [
                $model->id,
                $model->name,
                $model->getUser()->one()->first_name . ' ' . $model->getUser()->one()->last_name,
                Teammate::teammateUser($model->id),
                $model->date_created,
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


    public function actionView()
    {
        if (( $teamId = Yii::$app->request->get("id") ) ) {

            $model = Team::find()
                ->where("id=:teamiD",
                    [
                        ':teamiD' => $teamId
                    ])
                ->one();

     /*   if ( $model->load(Yii::$app->request->post()) ) {
            var_dump($model->teammate);
            exit();
            $model1 = Teammate::find()
                ->where("team_id=:teamId",[
                    ':teamId' => $teamId
                ])
                ->one();
            $model1->user_id = $model->user_id;
            //var_dump($model1);
            //exit();
            if ($model1->validate()) {
                $model1->save();
            }
        }*/
        }
        /*return $this->render('view', ['model' => $model]);*/

        /** @var $model Teammate */
        return $this->render('view', ['model' => $model,
            'title' => 'List of Teammates  #' . $model->id]);
    }

}