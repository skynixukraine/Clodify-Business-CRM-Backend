<?php

use yii\db\Migration;

class m170131_103629_invoices_total_negative_values extends Migration
{
    public function up()
    {
        $this->update('invoices', ['total' => 0], 'total < 0');

    }

    public function down()
    {
        echo "m170131_103629_invoices_total_negative_values cannot be reverted.\n";

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
