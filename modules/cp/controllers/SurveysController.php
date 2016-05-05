<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 15:58
 */
namespace app\modules\cp\controllers;
use app\models\Surveys;
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN, User::ROLE_PM, User::ROLE_CLIENT, User::ROLE_FIN],
                    ],
                    [

                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get', 'post'],

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
            'total_votes'
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
        if($dateEnd && $dateEnd != null){

            $dataTable->setFilter('date_end <= "' . DateUtil::convertData($dateEnd). '"');

        }
    }

}