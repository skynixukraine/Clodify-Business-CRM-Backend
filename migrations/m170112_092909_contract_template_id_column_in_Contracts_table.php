<?php


use app\components\SkynixMigration;
use app\models\Contract;
use app\models\ContractTemplates;

class m170112_092909_contract_template_id_column_in_Contracts_table extends SkynixMigration
{
    public function up()
    {
        $this->addColumn(Contract::tableName(), 'contract_template_id', $this->integer());
        $this->createIndex(
            'idx-contracts-contract_template_id',
            Contract::tableName(),
            'contract_template_id'
        );
        $this->addForeignKey(
            'fk-contracts-contract_template_id',
            Contract::tableName(),
            'contract_template_id',
            ContractTemplates::tableName(),
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        echo "m170112_092909_contract_template_id_column_in_Contracts_table cannot be reverted.\n";

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
