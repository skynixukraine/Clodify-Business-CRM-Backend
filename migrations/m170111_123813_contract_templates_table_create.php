<?php

use yii\db\Migration;

class m170111_123813_contract_templates_table_create extends Migration
{
    public function up()
    {
        $this->createTable('contract_templates', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'content' => $this->text()
        ]);
    }

    public function down()
    {
        echo "m170111_123813_contract_templates_table_create cannot be reverted.\n";

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
