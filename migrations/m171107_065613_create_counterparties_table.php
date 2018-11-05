<?php

 use app\components\SkynixMigration;

/**
 * Handles the creation of table `counterparties`.
 */
class m171107_065613_create_counterparties_table extends SkynixMigration
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
        $this->createTable('counterparties', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('counterparties');
    }
}
