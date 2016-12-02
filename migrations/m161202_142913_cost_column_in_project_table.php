<?php

use yii\db\Migration;

class m161202_142913_cost_column_in_project_table extends Migration
{
    public function up()
    {
        $this->addColumn('projects', 'cost', $this->float());
    }

    public function down()
    {
        echo "m161202_142913_cost_column_in_project_table cannot be reverted.\n";

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
