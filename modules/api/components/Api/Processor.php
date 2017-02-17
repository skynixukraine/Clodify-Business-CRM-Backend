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
    const CODE_SUCCESS          = 'S200';
    const CODE_TOKEN_EXPIRED    = 'S501';
    const CODE_TOKEN_UNDEFINED  = 'S502';
    const CODE_METHOD_NOT_ALLOWED = 'S503';
    const CODE_NOT_ATHORIZED      = 'S504';
    const CODE_TEHNICAL_ISSUE     = 'S505'; //The technical issue, if any other error match
    const CODE_UNPROCESSABLE_JSON = 'S506';
    const CODE_INSERT_ERROR       = 'S207';
    const CODE_DELETE_ERROR       = 'S208';
    const CODE_UPDATE_ERROR       = 'S209';
    const CODE_ACTION_RESTRICTED  = 'S210';
    const ERROR_PARAM = 'error';

    const STATUS_CODE_SUCCESS       = 200;


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
    public function addError( $code, $message = null )
    {
        $this->viewModel->addError( $code, $message);
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
        if ( !in_array( Yii::$app->request->getMethod(), $methods ) ) {

            $this->addError( self::ERROR_PARAM, Message::get(self::CODE_METHOD_NOT_ALLOWED)  );


        }
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
        if ( $this->hasAccess( $this->access->getMethods(), $this->access->shouldCheckAccess() ) &&
            $this->getAccessModelToken() ) {

            $viewModel->setAccessTokenModel( $this->getAccessModelToken() );

        }
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