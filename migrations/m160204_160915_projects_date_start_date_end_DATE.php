<?php


use app\components\SkynixMigration;

class m160204_160915_projects_date_start_date_end_DATE extends SkynixMigration
{
    public function safeUp()
    {
        $this->alterColumn('projects', 'date_start', $this->date());
        $this->alterColumn('projects', 'date_end', $this->date());
    }

    public function down()
    {
        echo "m160204_160915_projects_date_start_date_end_DATE cannot be reverted.\n";

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
