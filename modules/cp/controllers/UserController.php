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
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\components\DataTable;
use app\components\AccessRule;
use app\models\Site;
use app\models\Story;
use app\models\Photo;
use app\models\User;
use app\models\Language;

class UserController extends Controller {

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
                        'roles' => [User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN ],
                    ]
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

    public function actionDelete()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) == Yii::$app->user->getIdentity()->role) {

            if (( $id = Yii::$app->request->post("id") ) ) {

                /** @var  $model User */
                $model  = User::findOne( $id );
                $model->is_delete = 1;
                $model->save(true, ['is_delete']);
                return json_encode([
                    "message"   => Yii::t("app", "You delete user " . $id),
                    "success"   => true
                ]);

            }

        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }

    }

    public function actionFind()
    {

        $order          = Yii::$app->request->getQueryParam("order");
        $search         = Yii::$app->request->getQueryParam("search");
        $keyword        = ( !empty($search['value']) ? $search['value'] : null);
        $query          = User::find();

        $columns        = array(
            'id',
            'first_name',
            'email',
            'phone',
            'date_login',
            'date_signup',
            'is_active',
        );
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

            $list[] = array(
                $model->id,
                $model->first_name . " " . $model->last_name,
                $model->email,
                $model->phone,
                $model->date_login,
                $model->date_signup,
                $model->is_active,
                $model->is_delete
            );

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

    public function actionInvite()
    {
        /** @var  $model User */
        $model = new User();
        if ( $model->load(Yii::$app->request->post())){

            if( $model->validate()) {

                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t("app", "You invite user"));
                return $this->refresh();

            }
        }
        return $this->render('invite',['model' => $model]);
    }
}