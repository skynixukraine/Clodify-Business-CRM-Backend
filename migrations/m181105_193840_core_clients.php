<?php
use app\components\SkynixMigration;

/**
 * Class m181105_193840_core_clients
 */
class m181105_193840_core_clients extends SkynixMigration
{

    public $isCore = true;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('clients', [
            'id'        => 'pk',
            'domain'    => 'varchar(80)',
            'name'      => 'varchar(255)',
            'email'     => 'varchar(255)',
            'first_name'    => 'varchar(255)',
            'last_name'     => 'varchar(255)',
            'trial_expires' => 'date',
            'prepaid_for'   => 'date',
            'mysql_user'    => 'varchar(45)',
            'mysql_password'=> 'varchar(45)',
            'is_active'     => $this->tinyInteger(1) . ' DEFAULT 1',
            'is_confirmed'  => $this->tinyInteger(1) . ' DEFAULT 1'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181105_193840_core_clients cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181105_193840_core_clients cannot be reverted.\n";

        return false;
    }
    */
}
