<?php

use yii\db\Migration;

/**
 * Handles the creation of table `financial_reports`.
 */
class m170721_083953_create_financial_reports_table extends Migration
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

        $this->createTable('financial_reports', [
            'id' => $this->primaryKey(),
            'report_data' => $this->integer(),
            'income' => $this->text(),
            'currency' => $this->double(),
            'expense_constant' => $this->text(),
            'expense_salary' => $this->double(),
            'investments' => $this->text(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('financial_reports');
    }
}
