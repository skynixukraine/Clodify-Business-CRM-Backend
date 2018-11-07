<?php


use app\components\SkynixMigration;


class m160414_105046_teams_add_column_team_leader_id extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'teams', 'team_leader_id', 'int(11) NULL');
    }

    public function down()
    {
        echo "m160414_105046_teams_add_column_team_leader_id cannot be reverted.\n";

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
