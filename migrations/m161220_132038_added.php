<?php

use yii\db\Migration;

class m161220_132038_added extends Migration
{
    public function up()
    {
        $this->addColumn('reports', 'cost', $this->decimal(10,2)->defaultValue('0'));
    }

    public function down()
    {
        echo "m161220_132038_added cannot be reverted.\n";

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
