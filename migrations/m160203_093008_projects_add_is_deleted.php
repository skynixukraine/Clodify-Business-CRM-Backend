<?php


use app\components\SkynixMigration;

class m160203_093008_projects_add_is_deleted extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'projects', 'is_delete', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        echo "m160203_093008_projects_add_is_deleted cannot be reverted.\n";

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
