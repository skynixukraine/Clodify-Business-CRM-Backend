<?php


use app\components\SkynixMigration;


class m160317_130740_invoices_add_is_delete extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'invoices', 'is_delete', 'tinyint(1) DEFAULT 0');

    }

    public function down()
    {
        echo "m160317_130740_invoices_add_is_delete cannot be reverted.\n";

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
