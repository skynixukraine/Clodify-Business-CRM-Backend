<?php

use yii\db\Migration;
use yii\db\Schema;
use app\models\User;

class m161222_135151_new_table_contracts extends Migration
{
    public function up()
    {
        $this->createTable('contracts', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'act_number' => $this->integer(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'act_date' => $this->date(),
            'total' => $this->money(),
        ]);

        $this->createIndex(
            'idx-contracts-customer_id',
            'contracts',
            'customer_id'
        );

        $this->addForeignKey(
            'fk-contracts-customer_id',
            'contracts',
            'customer_id',
            User::tableName(),
            'id'
        );

    }

    public function down()
    {
        echo "m161222_135151_new_table_contracts cannot be reverted.\n";

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
