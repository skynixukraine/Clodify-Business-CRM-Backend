<?php

 use app\components\SkynixMigration;

class m180321_095840_projects_total_approved_hours extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'projects', 'total_approved_hours', $this->integer());
    }

    public function down()
    {
        echo "m180321_095840_projects_total_approved_hours cannot be reverted.\n";

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
