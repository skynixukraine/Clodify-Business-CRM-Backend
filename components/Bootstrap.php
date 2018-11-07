<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/7/18
 * Time: 1:19 PM
 */

namespace app\components;

use Yii;
use app\models\CoreClient;
use yii\base\BootstrapInterface;


class Bootstrap implements BootstrapInterface
{
    const DOMAIN_DEVELOP = 'develop.core.api.skynix.co';
    const DOMAIN_STAGING = 'staging.core.api.skynix.co';
    const DOMAIN_PRODUCT = 'core.api.skynix.co';
    public function bootstrap($app)
    {

       $host = parse_url(\Yii::$app->request->getAbsoluteUrl(), PHP_URL_HOST);
       switch ($host) {

            case self::DOMAIN_DEVELOP :
            case self::DOMAIN_STAGING :
            case self::DOMAIN_PRODUCT :

                break;
            default :

                $clientDomain = str_replace("-", "_", str_replace(['.api.skynix.co', 'develop.', 'staging.'], '', $host));
                if ( !empty($clientDomain ) &&
                    ($client = CoreClient::find()->where(['domain' => $clientDomain])->one())) {

                    $dsnParts = explode(";", Yii::$app->db->dsn);
                    $dsn = $dsnParts[0] . ';name=<dbname>';

                    $dbName = \Yii::$app->params['databasePrefix'] . $clientDomain;

                    Yii::$app->db->close();
                    Yii::$app->db->dsn      = str_replace('<dbname>', $dbName, $dsn);
                    Yii::$app->db->username = $client->mysql_user;
                    Yii::$app->db->password = $client->mysql_password;
                    Yii::$app->db->open();
                    Yii::$app->db->createCommand("use " . $dbName)->execute();

                } else {

                    throw new \Exception("Service not found", 404);

                }
                break;
        }
    }
}