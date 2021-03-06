<?php

 use app\components\SkynixMigration;

/**
 * Class m181031_152433_correct_project_status_canceled
 */
class m181031_152433_correct_project_status_canceled extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('projects', 'status', "enum('NEW', 'ONHOLD', 'INPROGRESS', 'DONE','CANCELLED') DEFAULT 'NEW'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181031_152433_correct_project_status_canceled cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181031_152433_correct_project_status_canceled cannot be reverted.\n";

        return false;
    }
    */
}
