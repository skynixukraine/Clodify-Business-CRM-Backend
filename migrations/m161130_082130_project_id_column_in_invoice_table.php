<?php


use app\components\SkynixMigration;


class m161130_082130_project_id_column_in_invoice_table extends SkynixMigration
{
    public function up()
    {
        $this->addColumn('invoices', 'project_id', $this->integer());
    }

    public function down()
    {
        echo "m161130_082130_project_id_column_in_invoice_table cannot be reverted.\n";
        $this->dropColumn('invoices', 'project_id');
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
