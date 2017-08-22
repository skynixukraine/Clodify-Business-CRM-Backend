<?php

use yii\db\Migration;

/**
 * Handles the creation of table `salary_reports`.
 */
class m170822_115501_create_salary_reports_table extends Migration
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

        $this->createTable('salary_reports', [
            'id' => $this->primaryKey(),
            'report_date' => $this->timestamp(),
            'total_salary' => $this->double(),
            'oficial_salary' => $this->double(),
            'bonuses' => $this->double(),
            'hospital' => $this->double(),
            'day_off' => $this->double(),
            'overtime' => $this->double(),
            'other_surcharges' => $this->double(),
            'subtotal' => $this->double(),
            'currency_rate' => $this->double(),
            'total_to_pay' => $this->double(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('salary_reports');
    }
}
