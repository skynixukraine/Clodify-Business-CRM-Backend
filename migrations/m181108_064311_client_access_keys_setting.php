<?php

use app\components\SkynixMigration;

/**
 * Class m181108_064311_client_access_keys_setting
 */
class m181108_064311_client_access_keys_setting extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('settings', [
            'key'       => \app\models\Setting::CLIENT_ID,
            'value'     => null,
            'type'      => 'INT'
        ]);
        $this->insert('settings', [
            'key'       => \app\models\Setting::CLIENT_ACCESS_KEY,
            'value'     => null,
            'type'      => 'STRING'
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181108_064311_client_access_keys_setting cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181108_064311_client_access_keys_setting cannot be reverted.\n";

        return false;
    }
    */
}
