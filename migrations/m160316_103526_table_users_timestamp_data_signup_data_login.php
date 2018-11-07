<?php


use app\components\SkynixMigration;


class m160316_103526_table_users_timestamp_data_signup_data_login extends SkynixMigration
{
    public function safeUp()
    {
        $this->alterColumn('users', 'date_signup', $this->timestamp());
        $this->alterColumn('users', 'date_login', $this->timestamp());

    }

    public function down()
    {
        echo "m160316_103526_table_users_timestamp_data_signup_data_login cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transactionіі
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
