<?php

 use app\components\SkynixMigration;

class m170823_091142_create_salary_reports_tab extends SkynixMigration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('salary_reports', [
            'id' => $this->primaryKey(),
            'report_date' => $this->integer(),
            'total_salary' => $this->double(),
            'official_salary' => $this->double(),
            'bonuses' => $this->double(),
            'hospital' => $this->double(),
            'day_off' => $this->double(),
            'overtime' => $this->double(),
            'other_surcharges' => $this->double(),
            'subtotal' => $this->double(),
            'currency_rate' => $this->double(),
            'total_to_pay' => $this->double(),
            'number_of_working_days' => $this->integer(),
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('salary_reports');
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
