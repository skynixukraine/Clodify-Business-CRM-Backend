<?php

 use app\components\SkynixMigration;

/**
 * Handles the creation of table `settings`.
 */
class m171019_065952_create_settings_table extends SkynixMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('settings', [
            'id' => $this->primaryKey(),
            'key' => $this->string(),
            'value' => $this->integer(),
            'type' => "enum('INT', 'STRING')"
        ],$tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('settings');
    }
}
