<?php

 use app\components\SkynixMigration;

class m170404_140151_users_remove_not_null_for_invite_hash extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('users','invite_hash','varchar(45)');
    }

    public function down()
    {
        echo "m170404_140151_users_remove_not_null_for_invite_hash cannot be reverted.\n";

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
