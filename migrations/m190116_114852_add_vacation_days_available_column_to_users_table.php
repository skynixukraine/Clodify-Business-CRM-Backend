<?php

use app\components\SkynixMigration;

/**
 * Handles adding vacation_days_available to table `users`.
 */
class m190116_114852_add_vacation_days_available_column_to_users_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'vacation_days_available', $this->integer()->defaultValue(0));
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'vacation_days_available');
    }
}
