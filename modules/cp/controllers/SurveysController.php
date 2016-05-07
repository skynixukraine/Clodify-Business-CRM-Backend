<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 15:58
 */
namespace app\modules\cp\controllers;
use app\models\Surveys;
use app\models\SurveysOption;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use app\components\DataTable;
use app\components\DateUtil;
use Yii;

class SurveysController extends DefaultController
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
                        'actions'   => ['index', 'results', 'find', 'create', 'delete', 'edit'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_DEV],
                    ],
                    [

                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get', 'post'],
                    'find'      => ['get'],
                    'create'    =>['get', 'post'],
                    'edit'  =>['get', 'post'],
                    'delete'    => ['delete'],

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
        $dateStart          = Yii::$app->request->getQueryParam("date_start");
        $dateEnd            = Yii::$app->request->getQueryParam("date_end");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);
        $query              = Surveys::find();

        $columns        = [
            'id',
            'shortcode',
            'question',
            'description',
            'date_start',
            'date_end',
            'is_private',
            'user_id',
            'total_votes',
        ];
        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'question', $keyword],
                ['like', 'description', $keyword]

            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);
        $dataTable->setFilter(Surveys::tableName() . '.is_delete=0');
        /*if($dateEnd && $dateEnd != null){

            $dataTable->setFilter('date_end <= "' . DateUtil::convertData($dateEnd). '"');

        }*/
        $dataTable->setFilter('user_id = ' . Yii::$app->user->id);
        $activeRecordsData = $dataTable->getData();
        $list = array();
        /** @var $model \app\models\Surveys */
        foreach ( $activeRecordsData as $model ) {

            $list[] = [
                $model->id,
                $model->shortcode,
                $model->question,
                $model->date_start,
                $model->date_end,
                $model->is_private,
                $model->user_id,
                $model->total_votes
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
    /** Add new survey */
    public function actionCreate()
    {
        if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_DEV, User::ROLE_CLIENT, User::ROLE_FIN] ) ) {

            $model = new Surveys();
           /* $options = new SurveysOption();*/


            if ($model->load(Yii::$app->request->post())) {


                if ($model->validate()) {
                    $model->date_start = DateUtil::convertData($model->date_start);
                    $model->date_end = DateUtil::convertData($model->date_end);
                    $model->user_id = Yii::$app->user->id;
                    /*$options->name = $model->name;
                    $options->description = $model->descriptions;
                    $options->save();*/
                    $model->save();

                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You created project " . $model->id));
                    return $this->redirect(['index']);

                }else{
                    /* var_dump($model->getErrors());
                     exit();*/
                }
            }
            return $this->render('create', ['model' => $model,
                'title' => 'Create a new survey']);
        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }
    }
    /** Delete project */
    public function actionDelete()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) ) {

            if ( ( $id = Yii::$app->request->post("id") ) ) {

                /** @var  $model Surveys */
                $model  = Surveys::findOne( $id );
                $model->is_delete = 1;
                $model->save(true, ['is_delete']);
                return json_encode([
                    "message"   => Yii::t("app", "You deleted survey " . $id),
                    /*"success"   => true*/
                ]);
            }

        }else{

            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Ooops, you do not have priviledes for this action."));
            return $this->refresh();

        }
    }
    public function actionEdit()
    {
        if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_PM, User::ROLE_DEV] ) ){

            if( $id = Yii::$app->request->get('id') ) {

                $model  = Surveys::find()
                    ->where("id=:iD",
                        [
                            ':iD' => $id
                        ])
                    ->one();
                /** @var $model Surveys */
                if( $model->is_delete == 0) {

                    $model->date_start = DateUtil::reConvertData($model->date_start);
                    $model->date_end = DateUtil::reConvertData($model->date_end);

                    if ($model->load(Yii::$app->request->post())) {

                        if ($model->validate()) {



                                $model->save();
                                if(Yii::$app->request->post('updated')) {

                                    Yii::$app->getSession()->setFlash('success',
                                        Yii::t("app", "You edited survey " . $id));
                                }
                                return $this->redirect(['create']);


                        }
                    }
                }else{

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Oops, sorry, this survey is deleted and can not be accessible anymore"));
                    return $this->redirect(['create']);
                }

            }
            return $this->render('create', ['model' => $model,
                'title' => 'Edit the survey #' . $model->id]);

        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }

    }
    public function actionResults()
    {
        /** @var  $model Surveys*/
        /*$model = Surveys::findOne(['user_id' => 1]);
        if($model -> user_id ){
            $model -> result = Surveys::find()->sum('user_id');


        }*/
            /*return $this->render(['model' => $model]);*/
            return $this->render('results');

    }

}