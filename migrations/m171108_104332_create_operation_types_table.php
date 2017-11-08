<?php

use yii\db\Migration;

/**
 * Handles the creation of table `operation_types`.
 */
class m171108_104332_create_operation_types_table extends Migration
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
        $this->createTable('operation_types', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
        ],$tableOptions);

        $this->insert('operation_types', [
            'name' => 'Банківські операції',
        ]);
        $this->insert('operation_types', [
            'name' => 'Валютні операції',
        ]);
        $this->insert('operation_types', [
            'name' => 'Податки',
        ]);
        $this->insert('operation_types', [
            'name' => 'Податки на зарплату',
        ]);
        $this->insert('operation_types', [
            'name' => 'Статутний фонд',
        ]);
        $this->insert('operation_types', [
            'name' => 'Придбання ОЗ',
        ]);
        $this->insert('operation_types', [
            'name' => 'Нарахування Зарплати',
        ]);
    }

    public function safeDown()
    {
        $this->delete('news', ['id' => 1]);
        $this->delete('news', ['id' => 2]);
        $this->delete('news', ['id' => 3]);
        $this->delete('news', ['id' => 4]);
        $this->delete('news', ['id' => 5]);
        $this->delete('news', ['id' => 6]);
        $this->delete('news', ['id' => 7]);
        $this->dropTable('operation_types');
    }
}
