<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 05.05.16
 * Time: 15:58
 */
namespace app\modules\cp\controllers;
use app\models\Survey;
use app\models\SurveysOption;
use app\models\User;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
use yii\helpers\ArrayHelper;
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
                        'actions'   => ['index', 'results', 'find', 'create', 'delete', 'edit', 'code'],
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
                    'index'     =>   ['get', 'post'],
                    'find'      =>   ['get'],
                    'create'    =>   ['get', 'post'],
                    'edit'      =>   ['get', 'post'],
                    'delete'    =>   ['delete'],
                    'code'      =>   ['get', 'post']

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
        $query              = Survey::find();

        $columns        = [
            'id',
            'shortcode',
            'question',
            'date_start',
            'date_end',
            'is_private',
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
        $dataTable->setFilter(Survey::tableName() . '.is_delete=0');
        /*if($dateEnd && $dateEnd != null){

            $dataTable->setFilter('date_end <= "' . DateUtil::convertData($dateEnd). '"');

        }*/
        $dataTable->setFilter('user_id = ' . Yii::$app->user->id /*. ' OR is_private=0'*/);
        $activeRecordsData = $dataTable->getData();
        $list = array();
        /** @var $model \app\models\Survey */
        foreach ( $activeRecordsData as $model ) {

            $list[] = [
                $model->id,
                $model->shortcode,
                $model->question,
                DateUtil::convertDatetimeWithoutSecund($model->date_start),
                DateUtil::convertDatetimeWithoutSecund($model->date_end),
                $model->is_private,
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

            $model  = new Survey();
            $cycles = 0;
            $num    = 2;
            do{
                $model->shortcode = strtolower( Yii::$app->security->generateRandomString( $num ) );
                $model->validate(['shortcode']);
                $cycles++;
                if ( $cycles > $num * 5 ) {

                    $num++;

                }

            }while($model->getErrors('shortcode') && $cycles < 100 );

            $survayOptions = [new SurveysOption()];

           /* $options = new SurveysOption();*/


            if ($model->load(Yii::$app->request->post())) {

                $sOptions = SurveysOption::createMultiple(SurveysOption::classname());
                SurveysOption::loadMultiple($sOptions, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                        ActiveForm::validateMultiple($sOptions),
                        ActiveForm::validate($sOptions)
                    );
                }// validate all models
                $valid = $model->validate();
                $valid = SurveysOption::validateMultiple($sOptions) && $valid;


                if ($valid) {
                    $model->date_start  = DateUtil::convertDatetime($model->date_start);
                    $model->date_end    = DateUtil::convertDatetime($model->date_end);
                    $model->user_id     = Yii::$app->user->id;
                    $model->total_votes = 0;
                    $model->is_delete   = 0;
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($sOptions as $sOption) {
                                if(!$sOption->name ){
                                    continue;
                                }
                                $sOption->votes     = 0;
                                $sOption->survey_id = $model->id;
                                if (! ($flag = $sOption->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            Yii::$app->getSession()->setFlash('success', Yii::t("app", "You have created a new survey #" . $model->id));
                            return $this->redirect(['index']);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }



                }else{
                    /* var_dump($model->getErrors());
                     exit();*/
                }
            }
            return $this->render('create', ['model' => $model, 'survayOptions' => $survayOptions,
                'title' => 'Create a new survey']);
        } else {

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }
    }

    /**
     * @param $survey_id
     * @param $options - Array of ['name'=>'', 'description'=>'']
     */
    public function createSurveyOptions($survey_id, $options){
        if(!$options){
            return;
        }
        foreach($options as $option){
            $sOpt = new SurveysOption();
            $sOpt->name = $option['name'];
            $sOpt->description = $option['description'];
            $sOpt->save();
        }
    }
    public function actionEdit($id)
    {
        if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_CLIENT, User::ROLE_FIN, User::ROLE_PM, User::ROLE_DEV] ) ){

                /*///////////////////////////////////////////////////*/

                $model  = Survey::find()
                    ->where("id=:iD",
                        [
                            ':iD' => $id
                        ])
                    ->one();
                $survayOptions = $model->surveys;
                /*if(!$survayOptions){
                    $survayOptions = [new SurveysOption()];
                }*/
                /** @var $model Survey */
                if( $model->is_delete == 0) {



                    if ($model->load(Yii::$app->request->post())) {

                        $oldIDs = ArrayHelper::map($survayOptions, 'id', 'id');
                        $survayOptions = SurveysOption::createMultiple(SurveysOption::classname(), $survayOptions);
                        SurveysOption::loadMultiple($survayOptions, Yii::$app->request->post());
                        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($survayOptions, 'id', 'id')));

                        // ajax validation
                        if (Yii::$app->request->isAjax) {
                            Yii::$app->response->format = Response::FORMAT_JSON;
                            return ArrayHelper::merge(
                                ActiveForm::validateMultiple($survayOptions),
                                ActiveForm::validate($model)
                            );
                        }

                        // validate all models
                        $valid = $model->validate();
                        $valid = SurveysOption::validateMultiple($survayOptions) && $valid;
                        if ($valid) {


                            $transaction = \Yii::$app->db->beginTransaction();
                            try {

                                $model->date_start  = DateUtil::convertDatetime($model->date_start);
                                $model->date_end    = DateUtil::convertDatetime($model->date_end);
                                if ($flag = $model->save(false)) {
                                    if (! empty($deletedIDs)) {
                                        SurveysOption::deleteAll(['id' => $deletedIDs]);
                                    }
                                    foreach ($survayOptions as $survayOption) {
                                        $survayOption->survey_id = $model->id;
                                        $survayOption->votes     = 0;
                                        if (! ($flag = $survayOption->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }
                                }
                                if ($flag) {
                                    $transaction->commit();
                                    Yii::$app->getSession()->setFlash('success',
                                        Yii::t("app", "You edited survey " . $id));
                                    return $this->redirect(['edit','id'=>$model->id]);
                                }
                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }


                        }
                    }
                }else{

                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "Oops, sorry, this survey is deleted and can not be accessible anymore"));
                    return $this->redirect(['create']);
                }


            return $this->render('create', ['model' => $model, 'survayOptions' => (empty($survayOptions)) ? [new SurveysOption] : $survayOptions,
                'title' => 'Edit the survey #' . $model->id]);

        }else{

            throw new \Exception('Ooops, you do not have priviledes for this action');

        }

    }

    /** Delete project */
    public function actionDelete()
    {
        if( User::hasPermission( [User::ROLE_ADMIN] ) ) {

            if ( ( $id = Yii::$app->request->post("id") ) ) {

                /** @var  $model Survey */
                $model  = Survey::findOne( $id );
                if ($model->user_id = Yii::$app->user->id){
                    $model->is_delete = 1;
                    $model->save(true, ['is_delete']);
                    return json_encode([
                        "message"   => Yii::t("app", "You have deleted the survey #" . $id),
                        /*"success"   => true*/
                    ]);
                } else{
                    Yii::$app->getSession()->setFlash('error', Yii::t("app", "You can't delete this survey."));
                    return $this->refresh();
                }
            }

        }else{

            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Ooops, you do not have priviledes for this action."));
            return $this->refresh();

        }
    }
    public function actionCode()
    {
        if( User::hasPermission( [User::ROLE_ADMIN, User::ROLE_DEV, User::ROLE_PM, User::ROLE_FIN, User::ROLE_CLIENT] ) ) {

            if ( ( $shortcode = Yii::$app->request->post("shortcode") ) ) {

                /** @var  $model Survey */
                $model  = Survey::findOne( $shortcode );
                return $this->render('/s/', ["model" => $model]);
            }

        }else{

            Yii::$app->getSession()->setFlash('success', Yii::t("app", "Ooops, you do not have priviledes for this action."));
            return $this->render('/s');
            // return $this->refresh();

        }
    }


}