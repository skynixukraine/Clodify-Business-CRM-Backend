<?php

use yii\db\Migration;
use app\models\Invoice;
use app\models\User;

class m170220_091553_added_created_by_column_in_invoices_table extends Migration
{
    public function up()
    {
        $this->addColumn(Invoice::tableName(), 'created_by', $this->integer());

        $this->createIndex(
            'idx-invoices-created_by',
            Invoice::tableName(),
            'created_by'
        );

        $this->addForeignKey(
            'fk-invoices-created_by',
            Invoice::tableName(),
            'created_by',
            User::tableName(),
            'id'
        );
    }

    public function down()
    {
        echo "m170220_091553_added_created_by_column_in_invoices_table cannot be reverted.\n";

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
