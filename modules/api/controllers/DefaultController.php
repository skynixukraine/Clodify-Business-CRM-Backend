<?php

namespace app\modules\api\controllers;

use app\modules\api\components\ApiProcessor\ApiProcessor;
use yii\web\Controller;
use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\AccessRule;
/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * @var \yii\di\Container
     */
    public $di;
    public $controllerNamespace = 'app\modules\api\controllers';

	public function behaviors()
	{
        //API CORS http://www.yiiframework.com/doc-2.0/yii-filters-cors.html
        Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
        Yii::$app->response->headers->add('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, DELETE, PUT');
        Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'x-requested-with, Content-Type, origin, accept, fe-access-token');
        Yii::$app->response->headers->add('Access-Control-Max-Age', 1000);
        
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => \app\modules\api\components\ApiProcessor\ApiCustomAuth::className(),
			'except' => ['error'],
		];
		return $behaviors;
	}

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

	public function beforeAction($action)
    {

        //if (!parent::beforeAction($action)) {
           // return false;
       //}
        $this->di = new yii\di\Container();
        $this->di
            ->setSingleton('ApiProcessor', 'app\modules\api\components\ApiProcessor\ApiProcessor')
            ->set('app\modules\api\components\ApiProcessor\ApiProcessorAccessInterface',
                    'app\modules\api\components\ApiProcessor\ApiProcessorAccess');

        return true;

    }

    public function actionError()
    {

        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            // action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
            $message = Yii::t('yii', 'API Method not found.');

        } else {

            $message = Yii::t('yii', 'An internal server error occurred.');

        }

        Yii::$app->response->format     = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content    = json_encode( [
            ApiProcessor::CODE_TEHNICAL_ISSUE => $message
        ] );

    }
   
}
