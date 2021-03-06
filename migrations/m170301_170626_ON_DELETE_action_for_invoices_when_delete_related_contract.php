<?php

 use app\components\SkynixMigration;

class m170301_170626_ON_DELETE_action_for_invoices_when_delete_related_contract extends SkynixMigration
{
    public function up()
    {

        $foreignKeys = Yii::$app->db->schema->getTableSchema('invoices')->foreignKeys;

        if (isset($foreignKeys['fk-invoice_contract'])) {
            $this->dropForeignKey(
                'fk-invoice_contract',
                'invoices'
            );
        }
        $this->addForeignKey(
            'fk-invoice_contract',
            'invoices',
            'contract_id',
            'contracts',
            'id',
            'SET NULL'
        );
    }

    public function down()
    {
        echo "m170301_170626_ON_DELETE_action_for_invoices_when_delete_related_contract cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
