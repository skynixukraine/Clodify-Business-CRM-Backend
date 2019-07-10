<?php

use app\components\SkynixMigration;

/**
 * Class m190702_073842_project_environments_table
 */
class m190702_073842_create_project_environments_table extends SkynixMigration
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

        $this->createTable('project_environments', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'branch' => $this->string(150),
            'access_roles' => $this->string(25)->defaultValue('ADMIN, SALES, PM'),
            'last_updated' => $this->dateTime()->defaultExpression('now()'),
        ], $tableOptions);

        $this->createIndex(
            'idx-project_environments-project_id',
            'project_environments',
            'project_id'
        );

        $this->addForeignKey(
            'fk-project_environments-project_id',
            'project_environments',
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
        $this->dropForeignKey('fk-project_environments-project_id', 'project_environments');
        $this->dropIndex('idx-project_environments-project_id', 'project_environments');
        $this->dropTable('project_environments');
    }
}
