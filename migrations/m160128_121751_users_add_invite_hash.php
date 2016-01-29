<?php

use yii\db\Schema;
use yii\db\Migration;

class m160128_121751_users_add_invite_hash extends Migration
{
    public function up()
    {
        $this->addColumn( 'users', 'invite_hash', 'varchar(45) NOT NULL');
    }

    public function down()
    {
        echo "m160128_121751_users_add_invite_hash cannot be reverted.\n";

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
