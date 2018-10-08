<?php

use yii\db\Migration;

/**
 * Class m181006_125826_is_system_user
 */
class m181006_125826_is_system_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'is_system', $this->tinyInteger(1).' DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'is_system');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181006_125826_is_system_user cannot be reverted.\n";

        return false;
    }
    */
}
