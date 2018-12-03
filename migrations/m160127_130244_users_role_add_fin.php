<?php

use app\components\SkynixMigration;
use app\models\User;

class m160127_130244_users_role_add_fin extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('users', 'role', "enum('" . User::ROLE_ADMIN . "','" . User::ROLE_PM . "','"
                                                     . User::ROLE_DEV . "','" . User::ROLE_CLIENT . "','"
                                                     . User::ROLE_FIN . "') NOT NULL DEFAULT '" . User::ROLE_DEV . "'");
    }

    public function down()
    {
        echo "m160127_130244_users_role_add_fin cannot be reverted.\n";

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

