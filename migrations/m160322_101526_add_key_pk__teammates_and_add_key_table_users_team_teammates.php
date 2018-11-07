<?php


use app\components\SkynixMigration;


class m160322_101526_add_key_pk__teammates_and_add_key_table_users_team_teammates extends SkynixMigration
{
    public function safeUp()
    {
        $this->addPrimaryKey('teammates_pk', 'teammates', ['user_id', 'team_id']);
        $this->addForeignKey('teammates_users_id', 'teammates', 'user_id', 'users', 'id');
        $this->addForeignKey('teammates_team_id', 'teammates', 'team_id', 'teams', 'id');

    }

    public function safeDown()
    {
        echo "m160322_101526_add_key_pk__teammates_and_add_key_table_users_team_teammates cannot be reverted.\n";

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
