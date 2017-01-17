<?php
/**
 * Created by Skynix Team
 * Date: 12/17/16
 * Time: 07:17
 */
namespace app\modules\api\components\Api;

use app\modules\api\components\Message;
use Yii;
use viewModel\ViewModelAbstract;
use viewModel\ViewModelInterface;
use yii\db\ActiveRecordInterface;

class Processor
{
    const CODE_SUCCESS          = 'ECS200';
    const CODE_TOKEN_EXPIRED    = 'ECS501';
    const CODE_TOKEN_UNDEFINED  = 'ECS502';
    const CODE_METHOD_NOT_ALLOWED = 'ECS503';
    const CODE_NOT_ATHORIZED      = 'ECS504';
    const CODE_TEHNICAL_ISSUE     = 'ECS505'; //The technical issue, if any other error match
    const CODE_UNPROCESSABLE_JSON = 'ECS506';
    const CODE_INSERT_ERROR       = 'ECS207';
    const CODE_DELETE_ERROR       = 'ECS208';
    const CODE_UPDATE_ERROR       = 'ECS209';
    const CODE_ACTION_RESTRICTED  = 'ECS210';

    const STATUS_CODE_SUCCESS       = 200;
    const STATUS_CODE_UNAUTHORIZED  = 401;
    const STATUS_CODE_UNPROCESSABLE = 422;


    const METHOD_GET            = 'GET';
    const METHOD_POST           = 'POST';
    const METHOD_PUT            = 'PUT';
    const METHOD_DELETE         = 'DELETE';

    const HEADER_ACCESS_TOKEN   = 'skynix-crm-atoken';

    private $response;
    private $errors = [];
    private $accessTokenModel;

    /**
     * @var AccessInterface
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
                                 AccessInterface $apiProcessorAccess)
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

        //TODO if oAuth/tokens needed, this method should be filled in with code
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
        $viewModel->setModel( $this->getModel() )
            ->render();

        Yii::$app->end();
    }

    /**
     * @return \yii\base\Model |null
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