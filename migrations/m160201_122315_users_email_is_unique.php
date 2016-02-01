<?php

use yii\db\Schema;
use yii\db\Migration;

class m160201_122315_users_email_is_unique extends Migration
{
    public function up()
    {
        $this->createIndex('email', 'users', 'email', $unique=true);
    }

    public function down()
    {
        echo "m160201_122315_users_email_is_unique cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
