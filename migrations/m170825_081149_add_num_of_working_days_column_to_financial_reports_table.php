<?php

use yii\db\Migration;

/**
 * Handles adding num_of_working_days to table `financial_reports`.
 */
class m170825_081149_add_num_of_working_days_column_to_financial_reports_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $financialReportsTable = Yii::$app->db->schema->getTableSchema('financial_reports');

        if ($financialReportsTable && !isset($financialReportsTable->columns['num_of_working_days'])) {
            $this->addColumn('financial_reports', 'num_of_working_days', $this->integer());
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('financial_reports', 'num_of_working_days');
    }
}
