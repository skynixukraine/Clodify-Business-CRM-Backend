<?php

 use app\components\SkynixMigration;

class m171102_112931_add_is_approved_reports extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'reports', 'is_approved', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        echo "m171102_112931_add_is_approved_reports cannot be reverted.\n";

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
