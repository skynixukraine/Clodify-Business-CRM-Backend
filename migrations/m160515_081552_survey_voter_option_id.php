<?php


use app\components\SkynixMigration;


class m160515_081552_survey_voter_option_id extends SkynixMigration
{
    public function up()
    {
        $this->addColumn('survey_voters', 'option_id', 'INT(11)');
        $this->addForeignKey('fk_survey_voters_surveys_options', 'survey_voters', 'option_id', 'surveys_options', 'id');
    }

    public function down()
    {
        echo "m160515_081552_survey_voter_option_id cannot be reverted.\n";

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
