<?php

use yii\db\Migration;

/**
 * Handles the creation of table `counterparties`.
 */
class m171106_153436_create_counterparties_table extends Migration
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
            'name' => $this->string(45)
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
