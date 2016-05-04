<?php

use yii\db\Migration;

class m160504_153333_survey_options extends Migration
{
    public function safeUp()
    {
        $this->createTable('surveys_options', [
            'id'            => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'name'          => 'varchar(250)',
            'description'   => $this->text(),
            'survey_id'     => $this->integer(),
            'votes'         => $this->integer(11)
        ]);
        $this->createTable('survey_voters', [
            'id'        => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'user_id'   => $this->integer(11),
            'ip'        => 'varchar(25)',
            'ua_hash'   => 'varchar(45)',
            'survey_id' => $this->integer()
        ]);

    }

    public function safeDown()
    {
        echo "m160504_153333_survey_options cannot be reverted.\n";

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
