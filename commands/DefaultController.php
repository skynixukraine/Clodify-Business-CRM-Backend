<?php
/**
 * Create By Skynix Team
 * Author: oleksii
 * Date: 11/7/18
 * Time: 4:31 PM
 */

namespace app\commands;

use app\models\CoreClient;
use Yii;

class DefaultController extends \yii\console\Controller
{

    public function runAction($id, $params = [])
    {

        $clients = CoreClient::find()->all();

        $dsnParts = explode(";", Yii::$app->db->dsn);
        $dsn = $dsnParts[0] . ';name=<dbname>';

        foreach ( $clients as $client ) {


            echo "\n Running for " . $client->name . "\n\n";
            $dbName = \Yii::$app->params['databasePrefix'] . $client->domain;

            Yii::$app->db->close();
            Yii::$app->db->dsn      = str_replace('<dbname>', $dbName, $dsn);
            Yii::$app->db->username = $client->mysql_user;
            Yii::$app->db->password = $client->mysql_password;
            Yii::$app->db->open();
            Yii::$app->db->createCommand("use " . $dbName)->execute();

            parent::runAction($id, $params);


        }

    }
}