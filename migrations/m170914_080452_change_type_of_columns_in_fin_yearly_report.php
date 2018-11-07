<?php

 use app\components\SkynixMigration;

class m170914_080452_change_type_of_columns_in_fin_yearly_report extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('financial_yearly_reports', 'income', 'double');
        $this->alterColumn('financial_yearly_reports', 'expense_constant', 'double');
        $this->alterColumn('financial_yearly_reports', 'investments', 'double');
        $this->alterColumn('financial_yearly_reports', 'expense_salary', 'double');
        $this->alterColumn('financial_yearly_reports', 'difference', 'double');
        $this->alterColumn('financial_yearly_reports', 'bonuses', 'double');
        $this->alterColumn('financial_yearly_reports', 'corp_events', 'double');
        $this->alterColumn('financial_yearly_reports', 'profit', 'double');
        $this->alterColumn('financial_yearly_reports', 'balance', 'double');
        $this->alterColumn('financial_yearly_reports', 'spent_corp_events', 'double');
    }

    public function down()
    {
        echo "m170914_080452_change_type_of_columns_in_fin_yearly_report cannot be reverted.\n";

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
