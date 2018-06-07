<?php

use yii\db\Migration;

/**
 * Class m180606_144521_incoice_id
 */
class m180606_144521_incoice_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('invoices', 'invoice_id', $this->integer(11).'DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('invoices', 'invoice_id');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180606_144521_incoice_id cannot be reverted.\n";

        return false;
    }
    */
}
