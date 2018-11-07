<?php

 use app\components\SkynixMigration;

/**
 * Class m180804_114438_only_approved_hours
 */
class m180804_114438_only_approved_hours extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'pay_only_approved_hours', $this->integer(1).' DEFAULT 0');

        $this->update('users', [
            'pay_only_approved_hours'   => 1
        ], [

            //Experimental User
            'email' => 'vitalii@skynix.co'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180804_114438_only_approved_hours cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180804_114438_only_approved_hours cannot be reverted.\n";

        return false;
    }
    */
}
