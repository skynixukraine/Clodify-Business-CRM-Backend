<?php

use yii\db\Migration;

/**
 * Class m181102_144946_increase_crowd_token_length
 */
class m181102_144946_increase_crowd_token_length extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('api_auth_access_tokens', 'crowd_token', 'VARCHAR(100)');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181102_144946_increase_crowd_token_length cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181102_144946_increase_crowd_token_length cannot be reverted.\n";

        return false;
    }
    */
}
