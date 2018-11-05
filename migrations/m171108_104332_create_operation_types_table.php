<?php

 use app\components\SkynixMigration;

/**
 * Handles the creation of table `operation_types`.
 */
class m171108_104332_create_operation_types_table extends SkynixMigration
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
        $this->delete('operation_types', ['name' => 'Банківські операції']);
        $this->delete('operation_types', ['name' => 'Валютні операції']);
        $this->delete('operation_types', ['name' => 'Податки']);
        $this->delete('operation_types', ['name' => 'Податки на зарплату']);
        $this->delete('operation_types', ['name' => 'Статутний фонд']);
        $this->delete('operation_types', ['name' => 'Придбання ОЗ']);
        $this->delete('operation_types', ['name' => 'Нарахування Зарплати']);
        $this->dropTable('operation_types');
    }
}
