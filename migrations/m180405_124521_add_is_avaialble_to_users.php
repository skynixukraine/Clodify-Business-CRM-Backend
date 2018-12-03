<?php

 use app\components\SkynixMigration;

/**
 * Class m180405_124521_add_is_avaialble_to_users
 */
class m180405_124521_add_is_avaialble_to_users extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn( 'users', 'is_available', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180405_124521_add_is_avaialble_to_users cannot be reverted.\n";

        return false;
    }

}
