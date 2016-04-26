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
use yii\web\ForbiddenHttpException;

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
                        'actions'   => [ 'view', 'delete', 'deleteteam'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_FIN],
                    ],
                    [
                        'actions'   => [ 'view'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_FIN, User::ROLE_PM, User::ROLE_DEV],
                    ],
                    [
                        'actions'   => [ 'index', 'find'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_PM, User::ROLE_DEV],
                    ],
                    [
                        'actions'   => [ 'create'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get'],
                    'find'      => ['get'],
                    'view'      => ['get', 'post'],
                    'delete'    => ['delete'],
                    'create'    => ['get', 'post'],
                    'deleteteam'    => ['delete'],

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
            'team_leader_id',
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

        $dataTable->setFilter(Team::tableName() . '.is_deleted=0');


        $activeRecordsData = $dataTable->getData();
        $list = array();
        /** @var $model \app\models\Team */
        foreach ( $activeRecordsData as $model ) {

            $list[] = [
                $model->id,
                $model->name,
                $model->getLeader()->one()->first_name . ' ' . $model->getLeader()->one()->last_name,
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
        if (( $teamId = Yii::$app->request->get("id") ) && ($model = Team::findOne(['id' => $teamId])) ) {

            // Add protection against changed in URL team id for roles PM and DEV
            if (!$this->checkAccess($teamId)) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }

            if ( $model->load(Yii::$app->request->post()) ) {

                $model1 = new Teammate();
                if( Teammate::findOne(['team_id' => $model->id, 'user_id' => $model->user_id]) == null) {

                    if ($model->validate()) {

                        $model1->team_id = $model->id;
                        $model1->user_id = $model->user_id;
                        $model1->save();
                    }
                } else {

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "This user is already exist"));
                    return $this->render('view', ['model' => $model,
                        'title' => 'List of Teammates  #' . $model->id]);
                }
            }
            return $this->render('view', ['model' => $model,
                'title' => 'List of Teammates  #' . $model->id]);
        } else {
            /*return $this->render('view', ['model' => $model]);*/

            Yii::$app->getSession()->setFlash('error', Yii::t("app", "This command is not exist"));
            return $this->render('index');
        }
    }
    public function actionDeleteteam()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) ) {

            if ( ( $id = Yii::$app->request->post("id") ) ) {

                /** @var  $model Teammate */
                $model  = Team::findOne( $id );
                $model->is_deleted = 1;
                $model->save(true, ['is_deleted']);
                return json_encode([
                    "message"   => Yii::t("app", "You deleted team " . $id),
                    "success"   => true
                ]);
            }

        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }
    }

    /** Delete teammate */
    public function actionDelete()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) ) {
            /** @var  $model Teammate */
            if ( ( $team_id = Yii::$app->request->post("team_id") ) &&
                ( $user_id = Yii::$app->request->post("user_id") ) &&
                ( $model = Teammate::find()->where('user_id=:ID AND team_id=:teamID',
                    [':ID' => $user_id, ':teamID' => $team_id])->one() ) ) {

                /**  leader of team*/
                if( ( Team::findOne(['team_leader_id' => $user_id, 'id' => $team_id]) ) == null ) {

                    $model->is_deleted = 1;
                    $model->save(true, ['is_deleted']);
                    return json_encode([
                        "message"   => Yii::t("app", "User " . $user_id . " was deleted."),
                        "success"   => true
                    ]);

                } else {

                    return json_encode([
                        "message"   => Yii::t("app", "This user is leader. You can`t delete his."),
                        "success"   => true
                    ]);
                }
            }

        } else {

            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Ooops, you do not have priviledes for this action."));
            return $this->render('index');

        }
    }

    public function actionCreate()
    {
        $model = new Team();
        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->id;
            $model->date_created = date('Y-m-d');

            if ($model->validate()) {

                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You created new team " . $model->name));
                return $this->redirect('index');

            } else {

                Yii::$app->getSession()->setFlash('error', Yii::t("app", "The data is nit valid"));
                return $this->redirect('index');
            }

        }
        return $this->render('create',['model' => $model]);
    }

    /**
     * @param int $teamId
     * @return bool
     */
    protected function checkAccess($teamId)
    {
        if ($correctRole = User::hasPermission([User::ROLE_PM, User::ROLE_DEV])) {
            $isInTeam = in_array($teamId, User::getUserTeams(Yii::$app->user->identity->getId(), true));
            return $isInTeam;
        }
        return true;
    }

}