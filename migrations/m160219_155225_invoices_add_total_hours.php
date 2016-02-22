<?php

use yii\db\Schema;
use yii\db\Migration;

class m160219_155225_invoices_add_total_hours extends Migration
{
    public function up()
    {
        $this->addColumn('invoices', 'total_hours', $this->double());
    }

    public function down()
    {
        echo "m160219_155225_invoices_add_total_hours cannot be reverted.\n";

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
