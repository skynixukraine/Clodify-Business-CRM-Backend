<?php

use app\components\SkynixMigration;

/**
 * Handles adding api_key to table `projects`.
 */
class m190702_073755_add_api_key_column_to_projects_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('projects', 'api_key', $this->string(32));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('projects', 'api_key');
    }
}
