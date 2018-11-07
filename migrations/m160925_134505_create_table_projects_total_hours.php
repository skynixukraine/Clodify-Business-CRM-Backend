<?php


use app\components\SkynixMigration;


class m160925_134505_create_table_projects_total_hours extends SkynixMigration
{
    public function safeUp()
    {
        $this->alterColumn('projects', 'total_logged_hours', $this->double());
        $this->alterColumn('projects', 'total_paid_hours', $this->double());

    }

    public function down()
    {
        echo "m160925_134505_create_table_projects_total_hours cannot be reverted.\n";

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
