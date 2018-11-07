<?php


use app\components\SkynixMigration;


class m160301_144739_invoices_add_contract_number_and_act_of_work extends SkynixMigration
{
    public function safeUp()
    {
        $this->addColumn('invoices', 'contract_number', $this->integer());
        $this->addColumn('invoices', 'act_of_work', $this->integer());
    }

    public function down()
    {
        echo "m160301_144739_invoices_add_contract_number_and_act_of_work cannot be reverted.\n";

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
