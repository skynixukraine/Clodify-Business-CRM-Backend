<?php

 use app\components\SkynixMigration;

class m170801_112518_add_spent_corp_events_col_to_finreport extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'financial_reports', 'spent_corp_events', $this->text());
    }

    public function down()
    {
        $this->dropColumn('financial_reports', 'spend_corp_events');
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
