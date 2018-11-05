<?php


use app\components\SkynixMigration;


class m160526_132832_rename_table_table_extensions extends SkynixMigration
{
    public function up()
    {
        $this->renameTable('table_extensions', 'extensions');
    }

    public function down()
    {
        echo "m160526_132832_rename_table_table_extensions cannot be reverted.\n";

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
