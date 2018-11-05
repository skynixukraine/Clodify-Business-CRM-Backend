<?php

 use app\components\SkynixMigration;

class m170721_142534_rename_report_date_column extends SkynixMigration
{
    public function up()
    {
        $table = Yii::$app->db->schema->getTableSchema('financial_reports');

        if (isset($table->columns['report_data'])) {
            $this->renameColumn('financial_reports', 'report_data', 'report_date');
        }
    }

    public function down()
    {
        echo "m170721_142534_rename_report_date_column cannot be reverted.\n";

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
