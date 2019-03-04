<?php

use app\components\SkynixMigration;

/**
 * Handles adding total_employees to table `salary_reports`.
 */
class m190304_100421_add_total_employees_column_to_salary_reports_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('salary_reports', 'total_employees', $this->integer()->defaultValue(0));
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('salary_reports', 'total_employees');
    }
}