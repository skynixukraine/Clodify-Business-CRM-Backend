<?php

use yii\db\Schema;
use yii\db\Migration;

class m160128_144305_users_phone_is_null extends Migration
{
    public function up()
    {
        $this->alterColumn( 'users', 'phone', 'varchar(45) NULL');
    }

    public function down()
    {
        echo "m160128_144305_users_phone_is_null cannot be reverted.\n";

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
