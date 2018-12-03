<?php

 use app\components\SkynixMigration;

/**
 * Class m180705_023535_create_system_user
 */
class m180705_023535_create_system_user extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('users', [
            'role'  => 'GUEST',
            'email' => 'apps@skynix.co',
            'password'  => '',
            'first_name'    => 'SKYNIX',
            'last_name'     => 'SYSTEM',
            'company'       => 'Skynix LLC',
            'is_active'     => 0,
            'auth_type'     => 2
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180705_023535_create_system_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180705_023535_create_system_user cannot be reverted.\n";

        return false;
    }
    */
}
