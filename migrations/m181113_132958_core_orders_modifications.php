<?php

use app\components\SkynixMigration;

/**
 * Class m181113_132958_core_orders_modifications
 */
class m181113_132958_core_orders_modifications extends SkynixMigration
{

    public $isCore = true;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('orders', 'payment_id');
        $this->dropColumn('orders', 'recurrent_id');
        $this->addColumn('orders', 'ref', $this->text());
        $this->addColumn('orders', 'payment', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181113_132958_core_orders_modifications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181113_132958_core_orders_modifications cannot be reverted.\n";

        return false;
    }
    */
}
