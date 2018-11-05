<?php


use app\components\SkynixMigration;


class m160606_100011_change_surveys_question extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('surveys', 'question', 'varchar(250)');
    }

    public function down()
    {
        echo "m160606_100011_change_surveys_question cannot be reverted.\n";

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
