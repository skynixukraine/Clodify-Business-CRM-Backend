<?php

use yii\db\Migration;

class m170822_124803_add_col_number_of_working_days_in_salrep extends Migration
{
    public function up()
    {
        $this->addColumn( 'salary_reports', 'number_of_working_days', $this->integer(100));
    }

    public function down()
    {
        $this->dropColumn('salary_reports', 'number_of_working_days');
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
