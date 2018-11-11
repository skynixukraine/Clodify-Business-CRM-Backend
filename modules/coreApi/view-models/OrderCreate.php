<?php
/**
 * Created by Skynix Team
 * Date: 20.11.18
 * Time: 11:22
 */

namespace viewModel;

use Yii;
use app\modules\api\components\Api\Processor;

class OrderCreate extends ViewModelAbstract{
    /**
     * @var CoreClient
     */
    protected $model;

    public function define()
    {

        $clientId = Yii::$app->request->getQueryParam('client_id');

        $this->model->client_id = $clientId;

        if($this->model->validate() && $this->model->save()) {
            return $this->setData([]);
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'the data is not valid'));
        }

    }


}