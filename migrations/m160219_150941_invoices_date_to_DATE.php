<?php


use app\components\SkynixMigration;


class m160219_150941_invoices_date_to_DATE extends SkynixMigration
{
    public function safeUp()
    {
        $this->alterColumn('invoices', 'date_created', $this->date());
        $this->alterColumn('invoices', 'date_paid', $this->date());
        $this->alterColumn('invoices', 'date_sent', $this->date());

    }



    public function down()
    {
        echo "m160219_150941_invoices_date_to_DATE cannot be reverted.\n";

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
