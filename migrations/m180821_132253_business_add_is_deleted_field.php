<?php

use yii\db\Migration;

/**
 * Class m180821_132253_business_add_is_deleted_field
 */
class m180821_132253_business_add_is_deleted_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn( 'busineses', 'is_delete', 'tinyint(1) DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180821_132253_business_add_is_deleted_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180821_132253_business_add_is_deleted_field cannot be reverted.\n";

        return false;
    }
    */
}
