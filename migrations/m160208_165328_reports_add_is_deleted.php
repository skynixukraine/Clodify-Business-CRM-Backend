<?php


use app\components\SkynixMigration;

class m160208_165328_reports_add_is_deleted extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'reports', 'is_delete', 'tinyint(1) DEFAULT 0');

    }

    public function down()
    {
        echo "m160208_165328_reports_add_is_deleted cannot be reverted.\n";

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
