<?php


use app\components\SkynixMigration;


class m160929_193333_add_id_sales_table_project_developers extends SkynixMigration
{
    public function safeUp()
    {
        $this->addColumn( 'project_developers', 'is_sales', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        echo "m160929_193333_add_id_sales_table_project_developers cannot be reverted.\n";

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
