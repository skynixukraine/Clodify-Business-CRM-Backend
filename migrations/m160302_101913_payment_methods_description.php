<?php


use app\components\SkynixMigration;


class m160302_101913_payment_methods_description extends SkynixMigration
{
    public function up()
    {

    }

    public function down()
    {
        echo "m160302_101913_payment_methods_description cannot be reverted.\n";

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
