<?php

use yii\db\Migration;
use app\models\Contract;
use app\models\User;

class m161226_153339_created_by_column_in_contracts_table extends Migration
{
    public function up()
    {
        $this->addColumn(Contract::tableName(), 'created_by', $this->integer());

        $this->createIndex(
            'idx-contracts-created_by',
            'contracts',
            'created_by'
        );

        $this->addForeignKey(
            'fk-contracts-created_by',
            'contracts',
            'created_by',
            User::tableName(),
            'id'
        );
    }

    public function down()
    {
        echo "m161226_153339_created_by_column_in_contracts_table cannot be reverted.\n";

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
