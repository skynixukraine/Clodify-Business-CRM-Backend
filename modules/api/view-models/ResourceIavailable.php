<?php
/**
 * Created by Skynix Team
 * Date: 3.0.17
 * Time: 12:00
 */

namespace viewModel;


use app\models\User;
use app\modules\api\components\Api\Processor;
use app\modules\api\models\ApiAccessToken;
use Yii;

/**
 * Class FinancialReportCreate
 *
 * @package viewModel
 * @see     https://jira-v2.skynix.company/browse/SI-1031
 * @author  Igor (Skynix)
 */
class ResourceIavailable extends ViewModelAbstract
{

    public function define()
    {
        $accessToken = Yii::$app->request->headers->get(Processor::HEADER_ACCESS_TOKEN);
        $accessTokenModel = ApiAccessToken::findOne(['access_token' => $accessToken ] );

       var_dump($accessToken);

    }

}