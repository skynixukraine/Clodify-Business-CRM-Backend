<?php

 use app\components\SkynixMigration;

class m170829_063540_change_type_of_actually_worked_out_salary extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('salary_report_lists', 'actually_worked_out_salary', 'double');
    }

    public function down()
    {
        echo "m170829_063540_change_type_of_actually_worked_out_salary cannot be reverted.\n";

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
