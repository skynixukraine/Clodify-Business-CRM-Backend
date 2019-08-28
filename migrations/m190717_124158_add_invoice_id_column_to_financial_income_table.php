<?php

use app\components\SkynixMigration;

/**
 * Handles adding invoice_id to table `financial_income`.
 */
class m190717_124158_add_invoice_id_column_to_financial_income_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('financial_income', 'invoice_id', $this->integer()->defaultValue(null));

        $this->createIndex(
            'idx-financial_income-invoice_id',
            'financial_income',
            'invoice_id'
        );

        $this->addForeignKey(
            'fk-financial_income-invoice_id',
            'financial_income',
            'invoice_id',
            'invoices',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-financial_income-invoice_id', 'financial_income');
        $this->dropIndex('idx-financial_income-invoice_id', 'financial_income');
        $this->dropColumn('financial_income', 'invoice_id');
    }
}
