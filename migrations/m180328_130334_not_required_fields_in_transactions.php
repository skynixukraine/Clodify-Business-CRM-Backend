<?php

 use app\components\SkynixMigration;

class m180328_130334_not_required_fields_in_transactions extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('transactions', 'counterparty_id', $this->integer().' DEFAULT NULL');
    }

    public function down()
    {
        echo "m180328_130334_not_required_fields_in_transactions cannot be reverted.\n";

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
