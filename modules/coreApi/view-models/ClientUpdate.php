<?php
/**
 * Created by Skynix Team
 * Date: 20.11.18
 * Time: 11:22
 */

namespace viewModel;

use app\models\CoreClient;
use Yii;
use app\modules\api\components\Api\Processor;

class ClientUpdate extends ViewModelAbstract
{
    /**
     * @var CoreClient
     */
    protected $model;

    public function define()
    {

        $clientId = Yii::$app->request->getQueryParam('client_id');

        if(is_null($this->model = CoreClient::findOne($clientId))){
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'client was not found'));
        }

        $this->model->setScenario( CoreClient::SCENARIO_UPDATE_VALIDATION );

        $this->model->attributes = $this->postData;

        if($this->model->validate() && $this->model->save()) {
            $this->setData([]);
        } else{
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'the input data is not valid'));
        }

    }
}