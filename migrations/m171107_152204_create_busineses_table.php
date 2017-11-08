<?php

use yii\db\Migration;

/**
 * Handles the creation of table `busineses`.
 */
class m171107_152204_create_busineses_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('busineses', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)
        ],$tableOptions);

        $this->insert('busineses', [
            'name' => 'TOV Skynix'
        ]);
    }

    public function safeDown()
    {
        $this->delete('busineses', ['id' => 1]);
        $this->dropTable('busineses');
    }
}
