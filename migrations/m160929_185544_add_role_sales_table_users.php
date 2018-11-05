<?php


use app\components\SkynixMigration;

use app\models\User;

class m160929_185544_add_role_sales_table_users extends SkynixMigration
{
    public function safeUp()
    {
        $this->alterColumn('users', 'role', "enum('" . User::ROLE_ADMIN . "','" . User::ROLE_PM . "','"
            . User::ROLE_DEV . "','" . User::ROLE_CLIENT . "','"
            . User::ROLE_FIN . "','" . User::ROLE_SALES . "') NOT NULL DEFAULT '" . User::ROLE_DEV . "'");

    }

    public function down()
    {
        echo "m160929_185544_add_role_sales_table_users cannot be reverted.\n";

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
