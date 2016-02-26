<?php

use yii\db\Migration;

class m160226_113724_users_date_signup_date_login_date_salary_up_DATE extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('users', 'date_signup', $this->date());
        $this->alterColumn('users', 'date_login', $this->date());
        $this->alterColumn('users', 'date_salary_up', $this->date());

    }

    public function down()
    {
        echo "m160226_113724_users_date_signup_date_login_date_salary_up_DATE cannot be reverted.\n";

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
