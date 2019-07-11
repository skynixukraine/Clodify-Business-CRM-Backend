<?php

use app\components\SkynixMigration;

/**
 * Handles the creation of table `monitoring_services`.
 */
class m190711_070602_create_monitoring_services_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('monitoring_services', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'url' => $this->string(250),
            'is_enabled' => $this->boolean()->defaultValue(true),
            'status' => 'ENUM(\'new\', \'ready\', \'failed\') default null',
            'notification_emails' => $this->string(250),
            'notification_sent_date' => $this->dateTime()->defaultValue(null)
        ]);

        $this->createIndex(
            'idx-monitoring_services-project_id',
            'monitoring_services',
            'project_id'
        );

        $this->addForeignKey(
            'fk-monitoring_services-project_id',
            'monitoring_services',
            'project_id',
            'projects',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-monitoring_services-project_id', 'monitoring_services');
        $this->dropIndex('idx-monitoring_services-project_id', 'monitoring_services');
        $this->dropTable('monitoring_services');
    }
}
