<?php

use app\components\SkynixMigration;

/**
 * Class m181105_195338_core_client_keys
 */
class m181105_195338_core_client_keys extends SkynixMigration
{

    public $isCore = true;
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('keys', [
            'id'            => 'pk',
            'client_id'     => $this->integer(11),
            'access_key'    => 'varchar(45)',
            'valid_until'   => $this->date()
        ]);
        $this->addForeignKey('client_keys_fk', 'keys', 'client_id', 'clients', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181105_195338_core_client_keys cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181105_195338_core_client_keys cannot be reverted.\n";

        return false;
    }
    */
}
