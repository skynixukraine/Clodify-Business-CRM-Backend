<?php
/**
 * Created by Skynix Team
 * Date: 7/15/16
 * Time: 17:07
 */

namespace app\modules\api\components\ApiProcessor;

use app\modules\api\components\Message;
use Yii;
use viewModel\ViewModelAbstract;
use viewModel\ViewModelInterface;
use app\modules\api\models\ApiAccessToken;
use yii\db\ActiveRecordInterface;
use mdm\admin\components\Helper;

class ApiProcessor
{
    const CODE_SUCCESS          = 'F200';
    const CODE_TOKEN_EXPIRED    = 'F501';
    const CODE_TOKEN_UNDEFINED  = 'F502';
    const CODE_METHOD_NOT_ALLOWED = 'F503';
    const CODE_NOT_ATHORIZED      = 'F504';
    const CODE_TEHNICAL_ISSUE     = 'F505'; //The technical issue, if any other error match
    const CODE_UNPROCESSABLE_JSON = 'F506';
    const CODE_INSERT_ERROR       = 'F207';
    const CODE_DELETE_ERROR       = 'F208';
    const CODE_UPDATE_ERROR       = 'F209';
    const CODE_ACTION_RESTRICTED  = 'F210';

    const STATUS_CODE_SUCCESS       = 200;
    const STATUS_CODE_UNAUTHORIZED  = 401;
    const STATUS_CODE_UNPROCESSABLE = 422;


    const METHOD_GET            = 'GET';
    const METHOD_POST           = 'POST';
    const METHOD_PUT            = 'PUT';
    const METHOD_DELETE         = 'DELETE';
    const METHOD_OPTIONS        = 'OPTIONS';

    const HEADER_ACCESS_TOKEN   = 'access-token';

    private $response;
    private $errors = [];
    private $accessTokenModel;

    /**
     * @var ApiProcessorAccessInterface
     */
    private $access;

    /**
     * @var \yii\db\ActiveRecord
     */
    private $model;

    /**
     * @var ViewModelInterface
     */
    private $viewModel;

    public function __construct( ActiveRecordInterface $model,
                                 ViewModelInterface $viewModel,
                                 ApiProcessorAccessInterface $apiProcessorAccess)
    {
        $this->response     = new \stdClass();
        $this->model        = $model;
        $this->viewModel    = $viewModel;
        $this->access       = $apiProcessorAccess;
        
        if ( in_array( Yii::$app->request->getMethod(), [ self::METHOD_POST, self::METHOD_PUT ] ) &&
            $this->model &&
            ( $json = Yii::$app->request->getRawBody() ) ) {

            if  ( ($data = @json_decode($json, true) ) ) {

                $this->model->setAttributes( $data );
                $this->viewModel->setPostData( $data );

            } else {

                $this->addError( self::CODE_UNPROCESSABLE_JSON );

            }

        }
    }

    /**
     * @param $code
     * @return $this
     */
    public function addError( $code )
    {
        $this->viewModel->addError( $code );
        return $this;
    }

    /**
     * This method checks if user is athorized or not according to the token in header
     * @param array $methods
     * @return bool
     */
    private function hasAccess(
                        $methods = [ self::METHOD_GET, self::METHOD_POST , self::METHOD_PUT , self::METHOD_DELETE ],
                        $checkAccess = true )
    {

        if ( $checkAccess === null ) {

            $checkAccess = true;
            
        }
        $accessToken = null;
        $methods[] = self::METHOD_OPTIONS;

        //var_dump(Yii::$app->request->getHeaders()); exit;
        if ( !in_array( Yii::$app->request->getMethod(), $methods ) ) {

            $this->addError( self::CODE_METHOD_NOT_ALLOWED );

        }
        if ( Yii::$app->request->getHeaders()->has(self::HEADER_ACCESS_TOKEN) &&
                count($this->getViewModel()->getErrors()) == 0 &&
                ( $accessToken = Yii::$app->request->getHeaders()->get(self::HEADER_ACCESS_TOKEN) ) &&
                ( $this->accessTokenModel = ApiAccessToken::findOne(['access_token' => $accessToken ] ) ) ) {


			// use yii2-admin helper function to check route permissions for currently requested route (+ extra check for omitted 'index')
            $route = '/' . Yii::$app->request->resolve()[0];

          /*  if ($checkAccess == true && !Helper::checkRoute($route) && !Helper::checkRoute($route . '/index')) {

                $this->addError(self::CODE_NOT_ATHORIZED);
				Yii::$app->response->statusCode = self::STATUS_CODE_UNAUTHORIZED;
			} */



			if ( strtotime( $this->accessTokenModel->exp_date ) > strtotime("now -" . ApiAccessToken::EXPIRATION_PERIOD ) ) {

                $this->accessTokenModel->exp_date = date("Y-m-d H:i:s");
                $this->accessTokenModel->save(false, ['exp_date']);

            } elseif ( $checkAccess == true ) {

                $this->addError( self::CODE_TOKEN_EXPIRED );

            }

        } elseif ( $checkAccess == true ) {

            $this->addError( self::CODE_NOT_ATHORIZED );
            Yii::$app->response->statusCode = self::STATUS_CODE_UNAUTHORIZED;

        }
        return ( count( $this->getViewModel()->getErrors() ) == 0  ? true : false );

    }
    

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function __set( $name, $value )
    {
        $this->response->$name = $value;
        return $this;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setRawResponse( $content )
    {
        $this->response = $content;
        return $this;
    }

    /**
     * This outputs JSON
     * @throws \yii\base\ExitException
     */
    public function respond()
    {

        $viewModel = $this->getViewModel();
        if ( $this->hasAccess( $this->access->getMethods(), $this->access->shouldCheckAccess() ) &&
                $this->getAccessModelToken() ) {

            $viewModel->setAccessTokenModel( $this->getAccessModelToken() );

        }
        $viewModel->setModel( $this->getModel() )
            ->render();
        
        Yii::$app->end();
    }

    /**
     * @return \app\components\ActivityModel|null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return ViewModelAbstract
     */
    public function getViewModel()
    {
        return $this->viewModel;
    }

    /**
     * @return mixed
     */
    public function getAccessModelToken()
    {
        return $this->accessTokenModel;
    }
}