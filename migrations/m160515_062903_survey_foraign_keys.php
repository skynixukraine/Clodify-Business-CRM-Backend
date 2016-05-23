<?php

use yii\db\Migration;

class m160515_062903_survey_foraign_keys extends Migration
{
    public function up()
    {

        $this->addForeignKey('fk_surveys_users', 'surveys', 'user_id', 'users', 'id');
        $this->addForeignKey('fk_surveys_options_users', 'surveys_options', 'survey_id', 'surveys', 'id');
        $this->addForeignKey('fk_survey_voters_users', 'survey_voters', 'user_id', 'users', 'id');
        $this->addForeignKey('fk_survey_voters_surveys', 'survey_voters', 'survey_id', 'surveys', 'id');

    }

    public function down()
    {
        echo "m160515_062903_survey_foraign_keys cannot be reverted.\n";

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
