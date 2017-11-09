<?php

use yii\db\Migration;

class m171109_125436_alter_column_id_in_operations extends Migration
{
    public function up()
    {
        $this->alterColumn('operations', 'id', $this->integer(11).' NOT NULL AUTO_INCREMENT');
    }

    public function down()
    {
        echo "m171109_125436_alter_column_id_in_operations cannot be reverted.\n";

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
