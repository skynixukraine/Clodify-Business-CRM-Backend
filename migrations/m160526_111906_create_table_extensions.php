<?php


use app\components\SkynixMigration;


/**
 * Handles the creation for table `table_extensions`.
 */
class m160526_111906_create_table_extensions extends SkynixMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('table_extensions', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'name' => 'varchar(250)',
            'repository' => 'varchar(250)',
            'type' => "enum('EXTENSION', 'THEME', 'LANGUAGE')",
            'version' => 'varchar(250)',
            'package' => 'varchar(250)'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('table_extensions');
    }
}
