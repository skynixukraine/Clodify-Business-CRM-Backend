<?php

use yii\db\Migration;

class m160601_074725_add_key_support_users extends Migration
{
    public function up()
    {
      /*  $this->addForeignKey('fk_support_tickets_users', 'support_tickets', 'client_id', 'users', 'id');
        $this->addForeignKey('fk_support_tickets_users', 'support_tickets', 'assignet_to', 'users', 'id');*/
    }

    public function down()
    {
        echo "m160601_074725_add_key_support_users cannot be reverted.\n";

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
