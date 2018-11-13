<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/13/18
 * Time: 10:03 AM
 */
namespace viewModel;

use app\models\CoreClient;
use app\modules\api\models\ApiAccessToken;
use Yii;
use app\models\User;
use app\modules\api\models\ApiLoginForm;
use app\modules\api\components\Api\Processor;
use yii\log\Logger;


class PaymentCallback extends ViewModelAbstract
{
    /**
     * @var CoreClient
     */
    protected $model;

    public function define()
    {

        Yii::getLogger()->log("========= STATUS ====== ", Logger::LEVEL_INFO);
        $json = Yii::$app->request->getRawBody();
        Yii::getLogger()->log($json, Logger::LEVEL_INFO);

    }
}