<?php

use yii\db\Migration;
use app\models\Invoice;

class m170105_105052_new_column_in_table_invoice extends Migration
{
    public function up()
    {
        $this->addColumn(Invoice::tableName(), 'user_projects', $this->string());
    }

    public function down()
    {
        echo "m170105_105052_new_column_in_table_invoice cannot be reverted.\n";

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
