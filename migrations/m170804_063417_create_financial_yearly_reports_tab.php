<?php

use yii\db\Migration;

class m170804_063417_create_financial_yearly_reports_tab extends Migration
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

        $this->createTable('financial_yearly_reports', [
            'id' => $this->primaryKey(),
            'year' => $this->integer(),
            'income'  => $this->integer(),
            'expense_constant'  => $this->integer(),
            'investments'  => $this->integer(),
            'expense_salary'  => $this->integer(),
            'difference'  => $this->integer(),
            'bonuses'  => $this->integer(),
            'corp_events'  => $this->integer(),
            'profit'  => $this->integer(),
            'balance'  => $this->integer(),
            'spent_corp_events'  => $this->integer(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('financial_yearly_reports');
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
