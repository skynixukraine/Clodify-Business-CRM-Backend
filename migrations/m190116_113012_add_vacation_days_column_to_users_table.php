<?php

use app\components\SkynixMigration;

/**
 * Handles adding vacation_days to table `users`.
 */
class m190116_113012_add_vacation_days_column_to_users_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'vacation_days', $this->integer()->defaultValue(0));
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'vacation_days');
    }
}
