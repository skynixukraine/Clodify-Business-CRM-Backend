<?php

use yii\db\Migration;
use app\models\Contract;
use app\models\PaymentMethod;

class m170112_100123_new_column_contract_payment_method_id_in_contracts_table extends Migration
{
    public function up()
    {
        $this->addColumn(Contract::tableName(), 'contract_payment_method_id', $this->integer());

        $this->createIndex(
            'idx-contracts-contract_payment_method_id',
            Contract::tableName(),
            'contract_payment_method_id'
        );

        $this->addForeignKey(
            'fk-contracts-contract_payment_method_id',
            Contract::tableName(),
            'contract_payment_method_id',
            PaymentMethod::tableName(),
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        echo "m170112_100123_new_column_contract_payment_method_id_in_contracts_table cannot be reverted.\n";

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
