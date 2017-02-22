<?php

namespace app\modules\api\controllers;

use app\modules\api\components\Api\Processor;
use yii\web\Controller;
use yii;

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
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    // Allow POST, PUT, GET, DELETE and OPTIONS methods
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                    // Allow only headers "x-requested-with, Content-Type, origin, accept, fe-access-token"
                    'Access-Control-Request-Headers' => ['x-requested-with', 'Content-Type',
                        'origin', 'accept', 'fe-access-token'],
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 1000,
                ],

            ],
        ];
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
        $this->di = new yii\di\Container();
        $this->di
            ->setSingleton('Processor', 'app\modules\api\components\Api\Processor')
            ->set('app\modules\api\components\Api\AccessInterface',
                    'app\modules\api\components\Api\Access');

        return parent::beforeAction($action);

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
        Yii::$app->response->content    = json_encode([
            'data'      => null,
            'errors'    => [
                'param'     => Processor::CODE_TEHNICAL_ISSUE,
                'message' => $message
            ],
            'success'   => false
        ]);

    }
   
}
