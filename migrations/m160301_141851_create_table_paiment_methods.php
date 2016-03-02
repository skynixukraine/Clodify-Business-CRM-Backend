<?php

use yii\db\Migration;

class m160301_141851_create_table_paiment_methods extends Migration
{
    public function up()
    {
        $this->createTable('payment_methods', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'name' => $this->string(45)->notNull(),
            'description' => $this->string(1000)
        ]);
    }

    public function down()
    {
        $this->dropTable('table_payment_methods');
    }
}
