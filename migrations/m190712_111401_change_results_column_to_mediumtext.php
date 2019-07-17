<?php

use app\components\SkynixMigration;

/**
 * Class m190712_111401_change_results_column_to_mediumtext_in_monitoring_service_queue_table
 */
class m190712_111401_change_results_column_to_mediumtext extends SkynixMigration
{
    public function up()
    {
        $this->alterColumn('monitoring_service_queue', 'results', 'MEDIUMTEXT DEFAULT NULL');
    }

    public function down()
    {
        $this->alterColumn('monitoring_service_queue', 'results', $this->text());
    }
}