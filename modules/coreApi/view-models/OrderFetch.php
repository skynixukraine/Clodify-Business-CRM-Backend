<?php
/**
 * Created by Skynix Team
 * Date: 20.11.18
 * Time: 11:22
 */

namespace viewModel;

use app\models\CoreOrder;
use app\models\CoreClient;
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

        if( ($coreClient = CoreClient::findOne($clientId) ) && ( $coreClient->is_active==0 )) {
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'The account is suspended'));
        }

        if($coreOrders = CoreOrder::find()->where(['client_id' => $clientId])->all()){
            $result= [];
            foreach ($coreOrders as $coreOrder) {
                $result[] = $this->defaultVal($coreOrder);
            }
            return $this->setData($result);
        } else{
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'order was not found'));
        }

    }


    /**
     * @param $model
     * @return mixed
     */
    function defaultVal($model) : Array
    {
        $list['id'] = $model->id;
        $list['status'] = $model->status;
        $list['amount'] = $model->amount;
        $list['payment_id'] = $model->payment_id;
        $list['recurrent_id'] = $model->recurrent_id;
        $list['created'] = $model->created;
        $list['paid'] = $model->paid;
        $list['notes'] = $model->notes;

        return $list;
    }


}