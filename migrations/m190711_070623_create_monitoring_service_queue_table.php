<?php

use app\components\SkynixMigration;

/**
 * Handles the creation of table `monitoring_service_queue`.
 */
class m190711_070623_create_monitoring_service_queue_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('monitoring_service_queue', [
            'id' => $this->primaryKey(),
            'service_id' => $this->integer(),
            'status' => 'ENUM(\'new\', \'in progress\', \'completed\', \'failed\')',
            'results' => $this->text(),
        ]);

        $this->createIndex(
            'idx-monitoring_service_queue-service_id',
            'monitoring_services',
            'project_id'
        );

        $this->addForeignKey(
            'fk-monitoring_service_queue-service_id',
            'monitoring_service_queue',
            'service_id',
            'monitoring_services',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-monitoring_service_queue-service_id', 'monitoring_service_queue');
        $this->dropIndex('idx-monitoring_service_queue-service_id', 'monitoring_service_queue');
        $this->dropTable('monitoring_service_queue');
    }
}
