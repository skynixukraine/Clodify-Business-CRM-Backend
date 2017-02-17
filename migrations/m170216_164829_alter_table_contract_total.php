<?php

use yii\db\Migration;

class m170216_164829_alter_table_contract_total extends Migration
{
    public function up()
    {
        $this->alterColumn('contracts', 'total', $this->decimal(19,2));
    }

    public function down()
    {
        echo "m170216_164829_alter_table_contract_total cannot be reverted.\n";

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
