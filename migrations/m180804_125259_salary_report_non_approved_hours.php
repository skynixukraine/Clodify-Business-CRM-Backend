<?php

 use app\components\SkynixMigration;

/**
 * Class m180804_125259_salary_report_non_approved_hours
 */
class m180804_125259_salary_report_non_approved_hours extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('salary_report_lists', 'non_approved_hours', $this->integer(11) . ' DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180804_125259_salary_report_non_approved_hours cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180804_125259_salary_report_non_approved_hours cannot be reverted.\n";

        return false;
    }
    */
}
