<?php

use app\components\SkynixMigration;

/**
 * Handles adding is_withdrawn to table `invoices`.
 */
class m190717_100923_add_is_withdrawn_column_to_invoices_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('invoices', 'is_withdrawn', $this->boolean()->defaultValue(false));

        $this->update('invoices', ['is_withdrawn' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('invoices', 'is_withdrawn');
    }
}
