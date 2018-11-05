<?php

use app\components\SkynixMigration;

/**
 * Class m181105_195543_core_first_client
 */
class m181105_195543_core_first_client extends SkynixMigration
{
    public $isCore = true;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $client = new \app\models\CoreClient();
        $client->domain = "skynix_llc";
        $client->name   = "Skynix LLC";
        $client->email  = "admin@skynix.co";
        $client->first_name     = "Skynix";
        $client->last_name      = "Admin";
        $client->trial_expires  = date('Y-m-d', strtotime('now +3years'));
        $client->prepaid_for    = null;
        $client->mysql_user     = "skynixcrm_db_user";
        $client->mysql_password    = "V7nk5j49gT77kTPmfN8THGxB9_";
        $client->is_active          = 1;
        $client->is_confirmed       = 1;
        $client->save();

        $clientKeys = new \app\models\CoreClientKey();
        $clientKeys->client_id      = $client->id;
        $clientKeys->valid_until    = date('Y-m-d', strtotime('now +3years'));
        $clientKeys->access_key     = Yii::$app->security->generateRandomString( 45 );
        $clientKeys->save();


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181105_195543_core_first_client cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181105_195543_core_first_client cannot be reverted.\n";

        return false;
    }
    */
}
