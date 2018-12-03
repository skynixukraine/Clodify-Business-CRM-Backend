<?php

 use app\components\SkynixMigration;

/**
 * Class m180611_170241_work_history_dates
 */
class m180611_170241_work_history_dates extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('work_history', 'date_start', 'DATE');
        $this->alterColumn('work_history', 'date_end', 'DATE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180611_170241_work_history_dates cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180611_170241_work_history_dates cannot be reverted.\n";

        return false;
    }
    */
}
