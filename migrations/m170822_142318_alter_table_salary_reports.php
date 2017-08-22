<?php

use yii\db\Migration;

class m170822_142318_alter_table_salary_reports extends Migration
{
    public function up()
    {
        $this->alterColumn('salary_reports', 'report_date', $this->bigInteger(100));
    }

    public function down()
    {
        echo "m170822_142318_alter_table_salary_reports cannot be reverted.\n";

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
