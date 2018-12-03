<?php

 use app\components\SkynixMigration;

/**
 * Class m180607_183036_salary_list_vacations
 */
class m180607_183036_salary_list_vacations extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('salary_report_lists', 'vacation_days', $this->integer(11));
        $this->addColumn('salary_report_lists', 'vacation_value', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180607_183036_salary_list_vacations cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180607_183036_salary_list_vacations cannot be reverted.\n";

        return false;
    }
    */
}
