<?php


use app\components\SkynixMigration;


class m160811_103916_add_column_table_invoice_paymet_method extends SkynixMigration
{
    public function safeUp()
    {
        $this->addColumn('invoices','payment_method_id', $this->integer());
    }

    public function down()
    {
        echo "m160811_103916_add_column_table_invoice_paymet_method cannot be reverted.\n";

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
