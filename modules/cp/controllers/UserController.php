<?php
/**
 * Created by WebAIS.
 * User: Oleksii
 * Date: 09.06.2015
 * Time: 13:09
 */

namespace app\modules\cp\controllers;
use app\models\SiteUser;
use app\models\Visit;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\DataTable;
use app\components\AccessRule;
use app\models\Site;
use app\models\Story;
use app\models\Photo;
use app\models\User;
use app\models\Language;

class UserController extends DefaultController {

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
                        'actions' => [ 'find', 'index', 'invite', 'delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                    [
                        'actions' => [ 'find', 'index', 'delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'find'      => ['get'],
                    'delete'    => ['delete'],
                    'invite'    => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    /*public function actionCreate()
    {

        $model              = new User();
        //$model->scenario    = "create";
        if ( Yii::$app->request->isPost ) {

            if ( $model->load( Yii::$app->request->post() ) && $model->validate()  ) {

                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You have successfully added the user"));
                return $this->redirect(['user/index']);

            }

        }
        return $this->render("create", array(
            'model'         => $model,
        ));
    }*/

    /** Delete user from Manage Users */
    public function actionDelete()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) ) {

            if (( $id = Yii::$app->request->post("id") ) ) {

                /** @var  $model User */
                $model  = User::findOne( $id );
                $model->is_delete = 1;
                $model->save(true, ['is_delete']);

                return json_encode([
                    "message"   => Yii::t("app", "User # " . $id ." has been deleted "),
                    //"success"   => true
                ]);
            }

        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');
        }
    }

    /** Value table (Manage Users) fields, filters, search */
    public function actionFind()
    {

        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);

        if( User::hasPermission([User::ROLE_PM, User::ROLE_ADMIN, User::ROLE_FIN])) {

            $query = User::find();
        }

        if( User::hasPermission([User::ROLE_CLIENT])){

            $workers = \app\models\ProjectCustomer::allClientWorkers(Yii::$app->user->id);
            $arrayWorkers = [];
            foreach($workers as $worker){
                $arrayWorkers[]= $worker->user_id;
            }
            $query = User::find()
            ->where(User::tableName() . '.id IN (' . implode( ', ', $arrayWorkers ) . ')') ;
        }
        $columns        = [
            'id',
            'first_name',
            'role',
            'email',
            'phone',
            'date_login',
            'date_signup',
            'is_active',
        ];
        $dataTable = DataTable::getInstance()
            ->setQuery( $query )
            ->setLimit( Yii::$app->request->getQueryParam("length") )
            ->setStart( Yii::$app->request->getQueryParam("start") )
            ->setSearchValue( $keyword ) //$search['value']
            ->setSearchParams([ 'or',
                ['like', 'last_name', $keyword],
                ['like', 'first_name', $keyword],
                ['like', 'phone', $keyword],
                ['like', 'email', $keyword]
            ]);

        $dataTable->setOrder( $columns[$order[0]['column']], $order[0]['dir']);

        $dataTable->setFilter('is_delete=0');

        $activeRecordsData = $dataTable->getData();
        $list = array();
        /* @var $model \app\models\User */
        foreach ( $activeRecordsData as $model ) {

            $list[] = [
                $model->id,
                $model->first_name . " " . $model->last_name,
                $model->role,
                $model->email,
                $model->phone,
                Yii::$app->formatter->asDateTime($model->date_login,'d/MM/Y H:i'),
                Yii::$app->formatter->asDateTime($model->date_signup,'d/MM/Y H:i'),

                ( $model->is_active == 1 ? "Yes " : "No" ),
                $model->is_delete
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

    /** Invited users add to database */
    public function actionInvite()
    {
        if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN ] ) ) {
            $model = new User();

            if ($model->load(Yii::$app->request->post())) {

                $userEmailes = User::find()
                    ->where('email=:Email', [
                        ':Email' => $model->email
                    ])->one();

                $model->password = User::generatePassword();
                /** @var $userEmailes User */
                /** Invite user that was deleted again */
                if (!empty($userEmailes) && $userEmailes->is_delete == 1) {

                    $userEmailes->is_delete = 0;
                    $userEmailes->is_active = 0;
                    $userEmailes->invite_hash = md5(time());
                    $userEmailes->first_name = $model->first_name;
                    $userEmailes->last_name = $model->last_name;
                    $userEmailes->role = $model->role;
                    $userEmailes->password = $model->password;
                    $userEmailes->rawPassword = $model->password;
                    $userEmailes->password = md5($model->password);
                    $userEmailes->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You invite user"));
                    return $this->redirect('index');

                } else {
                    /** Invite new user*/
                    if ($model->validate()) {

                    $model->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t("app", "You invite user"));
                    return $this->redirect('index');

                    }
                }
            }
        } else{
            throw new \Exception('Ooops, you do not have priviledes for this action');
        }
        return $this->render('invite',['model' => $model]);
    }
}