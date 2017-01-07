<?php

use yii\db\Migration;

class m170107_074133_invoice_contract extends Migration
{
    public function up()
    {
        $this->addColumn( \app\models\Invoice::tableName(), 'contract_id', $this->integer(11));
        $this->addForeignKey(
                'fk-invoice_contract',
                \app\models\Invoice::tableName(),
                'contract_id',
                \app\models\Contract::tableName(),
                'id',
                'CASCADE');

        $this->createIndex(
            'idx-invoice_contract',
            \app\models\Invoice::tableName(),
            'contract_id'
        );


    }

    public function down()
    {
        echo "m170107_074133_invoice_contract cannot be reverted.\n";

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
