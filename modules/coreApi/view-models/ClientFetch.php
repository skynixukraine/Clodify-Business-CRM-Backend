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
            return $this->addError(Processor::ERROR_PARAM, Yii::t('app', 'The account is suspended'));
        }

        $result = $client->defaultVal();

        return $this->setData($result);

    }

}