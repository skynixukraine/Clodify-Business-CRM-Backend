<?php


use app\components\SkynixMigration;


class m161201_091313_public_profile_key_in_users_table extends SkynixMigration
{
    public function up()
    {
        $this->addColumn('users', 'public_profile_key', $this->string(45));
    }

    public function down()
    {
        echo "m161201_091313_public_profile_key_in_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
