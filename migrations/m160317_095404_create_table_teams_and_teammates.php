<?php


use app\components\SkynixMigration;


class m160317_095404_create_table_teams_and_teammates extends SkynixMigration
{
    public function safeUp()
    {
        $this->createTable('teams', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'user_id'=>$this->integer()->notNull(),
            'name'=>$this->string(150)->notNull(),
            'date_created'=>$this->date(),
            'is_deleted'=>'tinyint(1) NOT NULL '
        ]);
        $this->createTable('teammates', [
            'team_id' => $this->integer()->notNull(),
            'user_id'=>$this->integer()->notNull()

        ]);
    }

    public function down()
    {
        $this->dropTable('teams');
        $this->dropTable('teammates');
    }
}
