<?php
/**
 * Created by Skynix Team
 * Date: 20.11.18
 * Time: 11:22
 */

namespace viewModel;

use app\models\CoreClientOrder;
use Yii;
use app\modules\coreApi\components\Api\Processor;

class OrderUpdate extends ViewModelAbstract{

    public function define()
    {

        $orderId = Yii::$app->request->getQueryParam('order_id');

        if(!($this->model = CoreClientOrder::findOne(['id' => $orderId]))) {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'order isn\'t found'));
        }

        $this->model->setScenario( CoreClientOrder::SCENARIO_UPDATE_VALIDATION );

        $this->model->attributes = $this->postData;

        if($this->model->validate() && $this->model->save()) {
            $this->setData([]);
        } else{
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'the input data is not valid'));
        }

    }


}