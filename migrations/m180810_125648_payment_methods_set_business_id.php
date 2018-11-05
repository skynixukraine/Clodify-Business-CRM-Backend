<?php

 use app\components\SkynixMigration;

/**
 * Class m180810_125648_payment_methods_set_business_id
 */
class m180810_125648_payment_methods_set_business_id extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('payment_methods', ['business_id' => 1], 'id = 1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180810_125648_payment_methods_set_business_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180810_125648_payment_methods_set_business_id cannot be reverted.\n";

        return false;
    }
    */
}
