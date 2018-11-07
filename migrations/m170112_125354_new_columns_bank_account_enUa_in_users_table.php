<?php



use app\components\SkynixMigration;

use app\models\User;

class m170112_125354_new_columns_bank_account_enUa_in_users_table extends SkynixMigration
{
    public function up()
    {
        $this->addColumn(User::tableName(), 'bank_account_en', $this->text());
        $this->addColumn(User::tableName(), 'bank_account_ua', $this->text());
    }

    public function down()
    {
        echo "m170112_125354_new_columns_bank_account_enUa_in_users_table cannot be reverted.\n";

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
