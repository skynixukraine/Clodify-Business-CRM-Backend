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

class ClientFetch extends ViewModelAbstract
{


    public function define()
    {

        $clientId = Yii::$app->request->getQueryParam('client_id');

        $client = CoreClient::findOne($clientId);

        if(is_null($client)){
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'client was not found'));
        }

        if($client->is_active==0){
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'client was not found'));
        }

        $result = $this->defaultVal($client);

        return $this->setData($result);

    }


    /**
     * @param $model
     * @return mixed
     */
    function defaultVal($model) : Array
    {
        $list['id'] = $model->id;
        $list['domain'] = $model->domain;
        $list['name'] = $model->name;
        $list['email'] = $model->email;
        $list['first_name'] = $model->first_name;
        $list['last_name'] = $model->last_name;
        $list['trial_expires'] = $model->trial_expires;
        $list['prepaid_for'] = $model->prepaid_for;
        $list['is_active'] = $model->is_active;

        return $list;
    }

}