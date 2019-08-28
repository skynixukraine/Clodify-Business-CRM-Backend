<?php

use yii\db\Migration;

/**
 * Handles adding exchange_rate to table `invoices`.
 */
class m190814_144954_add_exchange_rate_column_to_invoices_table extends \app\components\SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('invoices', 'exchange_rate', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('invoices', 'exchange_rate');
    }
}
