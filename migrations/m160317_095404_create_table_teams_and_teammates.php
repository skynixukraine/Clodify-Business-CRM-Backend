<?php

use yii\db\Migration;

class m160317_095404_create_table_teams_and_teammates extends Migration
{
    public function up()
    {
        /*$this->createTable('teams', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'user_id'=>$this->integer()->notNull(),
            'name'=>$this->string()->notNull(),
            'date_created'=>$this->date()
        ]);*/
    }

    public function down()
    {
        $this->dropTable('table_teams_and_teammates');
    }
}
