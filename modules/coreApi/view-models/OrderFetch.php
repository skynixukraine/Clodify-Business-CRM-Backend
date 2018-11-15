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

        $coreOrder = CoreOrder::findOne($clientId);
        $coreClient = CoreClient::findOne($clientId);

        if(is_null($coreOrder)){
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'order was not found'));
        }

        if($coreClient->is_active==0){
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'The account is suspended'));
        }

        $result = $this->defaultVal($coreOrder);

        return $this->setData($result);

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