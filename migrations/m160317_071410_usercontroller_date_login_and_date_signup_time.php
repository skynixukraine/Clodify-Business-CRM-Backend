<?php


use app\components\SkynixMigration;


class m160317_071410_usercontroller_date_login_and_date_signup_time extends SkynixMigration
{
    public function up()
    {

        $this->alterColumn( 'users', 'date_signup', 'timestamp NULL');
        $this->alterColumn( 'users', 'date_login', 'timestamp NULL');

    }

    public function down()
    {
        echo "m160317_071410_usercontroller_date_login_and_date_signup_time cannot be reverted.\n";

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
