<?php

use yii\db\Migration;

class m170802_113430_add_column_is_locked_tofinrep_table extends Migration
{
    public function up()
    {
        $this->addColumn( 'financial_reports', 'is_locked', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('financial_repots', 'is_locked');
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
