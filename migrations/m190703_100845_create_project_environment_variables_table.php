<?php

use app\components\SkynixMigration;

/**
 * Class m190703_100845_project_environment_variables_table
 */
class m190703_100845_create_project_environment_variables_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('project_environment_variables', [
            'id' => $this->primaryKey(),
            'project_environment_id' => $this->integer(),
            'name' => $this->string(200),
            'value' => $this->string(250)
        ], $tableOptions);

        $this->createIndex(
            'idx-project_environment_variables-project_environment_id',
            'project_environment_variables',
            'project_environment_id'
        );

        $this->addForeignKey(
            'fk-project_environment_variables-project_environment_id',
            'project_environment_variables',
            'project_environment_id',
            'project_environments',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-project_environment_variables-project_environment_id', 'project_environment_variables');
        $this->dropIndex('idx-project_environment_variables-project_environment_id', 'project_environment_variables');
        $this->dropTable('project_environment_variables');
    }
}
