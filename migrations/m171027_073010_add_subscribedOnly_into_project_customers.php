<?php

use yii\db\Migration;

class m171027_073010_add_subscribedOnly_into_project_customers extends Migration
{
    public function up()
    {
        $this->addColumn( 'project_customers', 'subscribedOnly', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        echo "m171027_073010_add_subscribedOnly_into_project_customers cannot be reverted.\n";

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
