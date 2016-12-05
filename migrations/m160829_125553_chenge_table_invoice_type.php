<?php

use yii\db\Migration;

class m160829_125553_chenge_table_invoice_type extends Migration
{
    public function up()
    {
        $this->alterColumn('invoices', 'total', 'double');
        $this->alterColumn('invoices', 'subtotal', 'double');

    }

    public function down()
    {
        echo "m160829_125553_chenge_table_invoice_type cannot be reverted.\n";

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
