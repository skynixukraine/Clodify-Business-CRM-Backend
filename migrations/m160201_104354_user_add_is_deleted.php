<?php

use yii\db\Schema;
use yii\db\Migration;

class m160201_104354_user_add_is_deleted extends Migration
{
    public function up()
    {
        $this->addColumn( 'users', 'is_delete', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        echo "m160201_104354_user_add_is_deleted cannot be reverted.\n";

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
