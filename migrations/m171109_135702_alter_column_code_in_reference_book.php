<?php

 use app\components\SkynixMigration;

class m171109_135702_alter_column_code_in_reference_book extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('reference_book', 'code', $this->string(5));
    }

    public function down()
    {
        echo "m171109_135702_alter_column_code_in_reference_book cannot be reverted.\n";

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
