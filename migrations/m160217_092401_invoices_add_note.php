<?php


use app\components\SkynixMigration;


class m160217_092401_invoices_add_note extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'invoices', 'note', 'varchar(1000) NULL');
    }

    public function down()
    {
        echo "m160217_092401_invoices_add_note cannot be reverted.\n";

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
