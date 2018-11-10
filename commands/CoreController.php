<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/8/18
 * Time: 8:40 AM
 */

namespace app\commands;

use app\models\Setting;
use Yii;
use yii\log\Logger;
use app\models\CoreClientKey;

class CoreController extends DefaultController
{
    /**
     *
     */
    public function actionUpdateClientAccessKeys()
    {
        try {
            Yii::getLogger()->log('actionUpdateClientAccessKeys running', Logger::LEVEL_INFO);

            $clientKeys = new \app\models\CoreClientKey();
            $clientKeys->client_id      = Setting::getClientId();
            $clientKeys->valid_until    = date('Y-m-d', strtotime('now +1day'));
            $clientKeys->access_key     = Yii::$app->security->generateRandomString( 45 );
            $clientKeys->save();

            if ( ( $setting = Setting::find()
                ->where(['key' => Setting::CLIENT_ACCESS_KEY])
                ->one() ) ) {

                $setting->value = $clientKeys->access_key;
                $setting->save(false, ['value']);
            }

        } catch (\Exception $e ) {

            Yii::getLogger()->log('actionUpdateClientAccessKeys error ' .
                $e->getMessage() .
                $e->getTraceAsString(),
                Logger::LEVEL_ERROR);
        }

    }
}