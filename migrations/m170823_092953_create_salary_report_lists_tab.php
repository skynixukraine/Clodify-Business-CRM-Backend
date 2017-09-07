<?php

use yii\db\Migration;

class m170823_092953_create_salary_report_lists_tab extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('salary_report_lists', [
            'id' => $this->primaryKey(),
            'salary_report_id' => $this->integer(),
            'user_id' => $this->integer(),
            'salary' => $this->integer(),
            'worked_days' => $this->integer(),
            'actually_worked_out_salary' => $this->integer(),
            'official_salary' => $this->double(),
            'hospital_days' => $this->integer(),
            'hospital_value' => $this->double(),
            'bonuses' => $this->double(),
            'day_off' => $this->integer(),
            'overtime_days' => $this->integer(),
            'overtime_value' => $this->double(),
            'other_surcharges' => $this->double(),
            'subtotal' => $this->double(),
            'currency_rate' => $this->double(),
            'subtotal_uah' => $this->double(),
            'total_to_pay' => $this->double(),
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('salary_report_lists');
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
