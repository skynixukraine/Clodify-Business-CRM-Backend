<?php

use yii\db\Migration;

/**
 * Handles the creation of table `salary_report_lists`.
 */
class m170822_144951_create_salary_report_lists_table extends Migration
{
    /**
     * @inheritdoc
     */
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
            'oficial_salary' => $this->double(),
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

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('salary_report_lists');
    }
}
