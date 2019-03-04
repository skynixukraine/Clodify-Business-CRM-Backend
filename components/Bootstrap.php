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

    //Bootstrap API for multidomain architecture
    public function bootstrap($app)
    {

       if ( Yii::$app->env->isCore() === false &&
            Yii::$app->env->isTest() === false ) {

           if ( Yii::$app->env->getClientDomain() &&
               ($client = CoreClient::find()->where(['domain' => Yii::$app->env->getClientDomain()])->one()) ) {

                $dsnParts = explode(";", Yii::$app->db->dsn);
                $dsn = $dsnParts[0] . ';name=<dbname>';
                $dbName = \Yii::$app->params['databasePrefix'] . Yii::$app->env->getClientDomain();

                Yii::$app->db->close();
                Yii::$app->db->dsn      = str_replace('<dbname>', $dbName, $dsn);
                Yii::$app->db->username = $client->mysql_user;
                Yii::$app->db->password = $client->mysql_password;
                Yii::$app->db->open();
                Yii::$app->db->createCommand("use " . $dbName)->execute();

           } else {

               throw new \Exception("Service not found", 404);

           }

       }

    }
}