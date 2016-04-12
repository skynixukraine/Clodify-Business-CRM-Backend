<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 21.03.16
 * Time: 15:41
 */
namespace app\modules\cp\controllers;
use app\components\DateUtil;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
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
                        'actions'   => [ 'index'],
                        'allow'     => true,
                        'roles'     => [User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'     => ['get']
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

<<<<<<< Updated upstream
=======
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


        }
        /*return $this->render('view', ['model' => $model]);*/

        /** @var $model Team */
        return $this->render('view', ['model' => $model,
            'title' => 'List of Teammates  #' . $model->id]);
    }
>>>>>>> Stashed changes

}