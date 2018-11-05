<?php


use app\components\SkynixMigration;

class m160322_081059_add_key_table_users_and_teams extends SkynixMigration
{
    public function up()
    {
        $this->addForeignKey('teams_users_id', 'teams', 'user_id', 'users', 'id');
    }

    public function down()
    {
        echo "m160322_081059_add_key_table_users_and_teams cannot be reverted.\n";

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
