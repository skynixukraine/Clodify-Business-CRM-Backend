<?php
/**
 * Created by Skynix Team
 * Date: 20.11.18
 * Time: 11:22
 */

namespace viewModel;

use app\models\CoreClientOrder;
use Yii;
use app\modules\api\components\Api\Processor;

class OrderFetch extends ViewModelAbstract{
    /**
     * @var CoreOrder
     */
    protected $model;

    public function define()
    {

        $clientId = Yii::$app->request->getQueryParam('client_id');

        if($coreClientOrders = CoreClientOrder::find()->where(['client_id' => $clientId])->all()){
            $result= [];
            foreach ($coreClientOrders as $coreClientOrder) {
                $result[] = $coreClientOrder->defaultVal();
            }
            return $this->setData($result);
        } else{
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'order was not found'));
        }

    }

}