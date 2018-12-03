<?php

use app\components\SkynixMigration;

/**
 * Class m181105_194841_core_client_orders
 */
class m181105_194841_core_client_orders extends SkynixMigration
{
    public $isCore = true;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('orders', [
            'id'            => 'pk',
            'client_id'     => $this->integer(11),
            'status'        => 'enum("NEW", "ONREVIEW", "PAID", "CANCELED")',
            'amount'        => $this->float(2),
            'payment_id'    => $this->integer(11),
            'recurrent_id'  => $this->integer(11),
            'created'       => $this->date(),
            'paid'          => $this->date(),
            'notes'         => $this->text(),
        ]);
        $this->addForeignKey('client_orders_fk', 'orders', 'client_id', 'clients', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181105_194841_core_client_orders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181105_194841_core_client_orders cannot be reverted.\n";

        return false;
    }
    */
}
