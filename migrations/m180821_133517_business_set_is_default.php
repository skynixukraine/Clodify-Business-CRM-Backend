<?php

use yii\db\Migration;

/**
 * Class m180821_133517_business_set_is_default
 */
class m180821_133517_business_set_is_default extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('busineses', ['is_default' => 1], 'id = 1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180821_133517_business_set_is_default cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180821_133517_business_set_is_default cannot be reverted.\n";

        return false;
    }
    */
}
