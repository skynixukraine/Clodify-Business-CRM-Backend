<?php

use yii\db\Migration;

class m170121_161110_new_column_is_invoiced_in_contracts_table extends Migration
{
    public function up()
    {
        $this->addColumn('contracts', 'is_invoiced', $this->integer());
    }

    public function down()
    {
        echo "m170121_161110_new_column_is_invoiced_in_contracts_table cannot be reverted.\n";

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
