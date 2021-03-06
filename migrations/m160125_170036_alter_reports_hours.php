<?php

use app\components\SkynixMigration;

class m160125_170036_alter_reports_hours extends SkynixMigration
{

    public function up()
    {
        $this->alterColumn('reports', 'hours', $this->double());
    }

    public function down()
    {
        echo "m160125_170036_alter_reports_hours cannot be reverted.\n";

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
