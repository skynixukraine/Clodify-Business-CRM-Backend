<?php
/**
 * Created by Skynix Team
 * Date: 8/6/16
 * Time: 11:32
 */

namespace viewModel;

use Yii;
use app\modules\api\components\Api\Message;
use app\modules\api\components\Api\Processor;
use app\modules\api\models\ApiAccessToken;
use yii\db\ActiveRecordInterface;
use yii\log\Logger;

abstract class ViewModelAbstract implements ViewModelInterface
{
    protected $data;
    protected $postData;
    protected $model;
    protected $errors = [];

    /**
     * @var ApiAccessToken
     */
    protected $token;

    /**
     * This is a view Model Definition
     * @return mixed
     */
    abstract public function define();

    /**
     * This function outputs the response to the browser
     */
    public function render()
    {

        if ( count($this->errors) == 0 ) {

            try {

                $this->define();

            } catch (\Exception $e ) {

                $this->data = null;
                $this->addError(Processor::CODE_TEHNICAL_ISSUE, $e->getMessage());
                Yii::getLogger()->log($e, Logger::LEVEL_ERROR);

            }

        } else {

            $this->data = null;

        }
        Yii::$app->response->statusCode = Processor::STATUS_CODE_SUCCESS;
        Yii::$app->response->format     = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->content    = json_encode([
            'data'      => $this->data,
            'errors'    => $this->errors,
            'success'   => count($this->errors) == 0 ? true : false
        ]);

    }

    /**
     * @param ActiveRecordInterface $model
     * @return $this
     */
    public function setModel( ActiveRecordInterface $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param $postData
     * @return $this
     */
    public function setPostData( $postData )
    {
        $this->postData = $postData;
        return $this;
    }

    /**
     * @param ApiAccessToken $token
     * @return $this
     */
    public function setAccessTokenModel( ApiAccessToken $token )
    {
        $this->token = $token;
        return $this;
    }

    public function addError( $code, $message = null )
    {
        $this->errors[] = [
            'param'     => $code,
            'message'   => ($message ? $message : Message::get($code))
        ];
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        if ( $this->model->validate() ) {
            return true;

        }
        if ( ( $errors = $this->model->getErrors() ) ) {

            $this->errors = [];
            foreach ( $errors as $key => $error ) {

                $this->addError( $key, implode(", ", $error) );

            }

        }
        return false;
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function setData( array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return ApiAccessToken
     */
    protected function getAccessTokenModel()
    {
        return $this->token;
    }

    /**
     * @param $variable
     * @param null $defaultValue
     * @return null
     */
    protected function getPost( $variable, $defaultValue = null )
    {
        return ( isset($this->postData[$variable]) ? $this->postData[$variable] : $defaultValue);
    }
}