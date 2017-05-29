<?php

use yii\db\Migration;

class m170404_081923_users_add_password_reset_token extends Migration
{
    public function up()
    {
        $this->addColumn( 'users', 'password_reset_token', 'varchar(45) unique');
    }

    public function down()
    {
        echo "m170404_081923_users_add_password_reset_token cannot be reverted.\n";

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
