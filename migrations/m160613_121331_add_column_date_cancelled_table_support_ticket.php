<?php


use app\components\SkynixMigration;

class m160613_121331_add_column_date_cancelled_table_support_ticket extends SkynixMigration
{
    public function safeUp()
    {
        $this->addColumn('support_tickets','date_cancelled', $this->dateTime());
    }

    public function down()
    {
        echo "m160613_121331_add_column_date_cancelled_table_support_ticket cannot be reverted.\n";

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
