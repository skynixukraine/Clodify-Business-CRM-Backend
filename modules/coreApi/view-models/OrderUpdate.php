<?php
/**
 * Created by Skynix Team
 * Date: 20.11.18
 * Time: 11:22
 */

namespace viewModel;

use Yii;
use app\modules\coreApi\components\Api\Processor;

class OrderUpdate extends ViewModelAbstract{

    public function define()
    {

        //$clientId = Yii::$app->request->getQueryParam('client_id');
        $orderId = Yii::$app->request->getQueryParam('order_id');

        $this->model = CoreOrder::find()->where(['order_id' => $orderId]);


        if($this->model->validate() && $this->model->save()) {
            return $this->setData([]);
        } else {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'the data is not valid'));
        }

    }


}