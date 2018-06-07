<?php

use yii\db\Migration;

/**
 * Class m180607_101217_user_address
 */
class m180607_101217_user_address extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'address', $this->string(250));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180607_101217_user_address cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180607_101217_user_address cannot be reverted.\n";

        return false;
    }
    */
}
